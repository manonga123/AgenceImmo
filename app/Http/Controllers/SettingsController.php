<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Agency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    /**
     * Afficher la page des paramètres
     */
    public function index(Request $request)
    {
        $data = [
            'user' => Auth::user(),
        ];

        if (auth()->user()->role === 'admin') {
            $data['agency'] = Agency::firstOrCreate([], [
                'name'  => config('app.name'),
                'email' => config('mail.from.address'),
            ]);

            $data['users'] = User::where('id', '!=', auth()->id())
                ->orderBy('created_at', 'desc')
                ->paginate(10, ['*'], 'users_page');
        }

        $data['activeSessions'] = $this->getActiveSessions();

        return view('settings.index', $data);
    }

    /**
     * Met à jour le profil de l'utilisateur connecté
     */
    public function updateProfile(Request $request)
    {
        // ✅ Utiliser find() pour avoir un modèle Eloquent frais et sauvegardable
        $user = User::find(Auth::id());

        $validated = $request->validate([
            'first_name'    => 'required|string|max:50',
            'last_name'     => 'required|string|max:50',
            'email'         => [
                'required', 'email', 'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone'         => 'nullable|string|max:20',
            'bio'           => 'nullable|string|max:500',
            'avatar'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'avatar_base64' => 'nullable|string',
        ]);

        try {
            // ─── Avatar via base64 (Cropper.js) ───────────────────────────────
            if ($request->filled('avatar_base64')) {
                $base64Image = $request->avatar_base64;

                if (preg_match('/^data:image\/(\w+);base64,/', $base64Image)) {
                    $imageData = base64_decode(substr($base64Image, strpos($base64Image, ',') + 1));

                    if (strlen($imageData) > 2 * 1024 * 1024) {
                        return back()
                            ->withErrors(['avatar' => 'L\'image est trop volumineuse (max 2 Mo).'])
                            ->withInput();
                    }

                    // Supprimer l'ancien avatar s'il existe
                    if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
                        Storage::disk('public')->delete($user->avatar_path);
                    }

                    Storage::disk('public')->makeDirectory('users/avatars');

                    $path = 'users/avatars/avatar_' . $user->id . '_' . time() . '.jpg';
                    Storage::disk('public')->put($path, $imageData);

                    // ✅ FIX : sauvegarder avatar_path directement en BDD ici
                    $user->avatar_path = $path;
                }
            }
            // ─── Avatar via input file (fallback) ─────────────────────────────
            elseif ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $file = $request->file('avatar');

                if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
                    Storage::disk('public')->delete($user->avatar_path);
                }

                $filename = 'avatar_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path     = $file->storeAs('users/avatars', $filename, 'public');

                // ✅ FIX : sauvegarder avatar_path directement en BDD ici
                $user->avatar_path = $path;
            }

            // Retirer les champs non-BDD de $validated
            unset($validated['avatar'], $validated['avatar_base64']);

            // ✅ fill() + save() sauvegarde TOUT en une seule requête,
            //    y compris avatar_path assigné juste au-dessus
            $user->fill($validated);
            $user->save();

            return redirect()->route('settings.index', ['tab' => 'profile'])
                ->with('success', 'Profil mis à jour avec succès.');

        } catch (\Exception $e) {
            \Log::error('Erreur mise à jour profil: ' . $e->getMessage() . ' — ' . $e->getFile() . ':' . $e->getLine());

            return back()
                ->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Mettre à jour le mot de passe
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Mot de passe mis à jour avec succès.');
    }

    /**
     * Mettre à jour les préférences de notification
     */
    public function updateNotifications(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'notifications'       => 'nullable|array',
            'notifications.*'     => 'string',
            'email_notifications' => 'boolean',
            'push_notifications'  => 'boolean',
            'marketing_emails'    => 'boolean',
            'visit_reminders'     => 'boolean',
        ]);

        if (isset($validated['notifications'])) {
            $validated['notification_preferences'] = json_encode($validated['notifications']);
            unset($validated['notifications']);
        }

        $user->update($validated);

        return back()->with('success', 'Préférences de notification mises à jour.');
    }

    /**
     * Mettre à jour les informations de l'agence (Admin seulement)
     */
    public function updateAgency(Request $request)
    {
        $this->authorize('admin', Auth::user());

        $validated = $request->validate([
            'name'          => 'required|string|max:100',
            'siret'         => 'nullable|string|max:14',
            'address'       => 'nullable|string|max:255',
            'city'          => 'nullable|string|max:100',
            'postal_code'   => 'nullable|string|max:10',
            'phone'         => 'nullable|string|max:20',
            'email'         => 'nullable|email',
            'website'       => 'nullable|url',
            'description'   => 'nullable|string',
            'opening_hours' => 'nullable|string',
            'logo'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $agency = Agency::firstOrCreate([]);

        if ($request->hasFile('logo')) {
            if ($agency->logo_path && Storage::exists($agency->logo_path)) {
                Storage::delete($agency->logo_path);
            }
            $validated['logo_path'] = $request->file('logo')->store('agency/logos', 'public');
        }

        $agency->update($validated);

        return back()->with('success', 'Informations de l\'agence mises à jour.');
    }

    /**
     * Mettre à jour les commissions (Admin seulement)
     */
    public function updateCommissions(Request $request)
    {
        $this->authorize('admin', Auth::user());

        $validated = $request->validate([
            'sale_commission'   => 'required|numeric|min:0|max:100',
            'rental_commission' => 'required|numeric|min:0|max:100',
            'vat_rate'          => 'required|numeric|min:0|max:100',
        ]);

        Agency::firstOrCreate([])->update($validated);

        return back()->with('success', 'Commissions mises à jour.');
    }

    /**
     * Mettre à jour les paramètres des propriétés
     */
    public function updateProperties(Request $request)
    {
        $validated = $request->validate([
            'per_page'                => 'required|integer|in:12,24,36,48',
            'default_sort'            => 'required|string|in:newest,price_asc,price_desc,surface_desc',
            'show_sold'               => 'boolean',
            'default_property_status' => 'nullable|string',
            'require_approval'        => 'boolean',
        ]);

        $user = Auth::user();
        $user->settings = array_merge((array) $user->settings, $validated);
        $user->save();

        return back()->with('success', 'Paramètres des propriétés mis à jour.');
    }

    /**
     * Mettre à jour les informations bancaires (Propriétaire)
     */
    public function updateBank(Request $request)
    {
        $this->authorize('owner', Auth::user());

        $validated = $request->validate([
            'account_holder' => 'required|string|max:100',
            'iban'           => 'required|string|max:34',
            'bic'            => 'required|string|max:11',
            'bank_name'      => 'required|string|max:100',
        ]);

        Auth::user()->update($validated);

        return back()->with('success', 'Informations bancaires mises à jour.');
    }

    /**
     * Mettre à jour les préférences propriétaire
     */
    public function updateOwnerPreferences(Request $request)
    {
        $this->authorize('owner', Auth::user());

        $validated = $request->validate([
            'auto_confirm_visits'          => 'boolean',
            'receive_visit_reminders'      => 'boolean',
            'max_response_time'            => 'integer|min:1|max:168',
            'preferred_contact_method'     => 'nullable|in:email,phone,sms',
            'notification_visit_request'   => 'boolean',
            'notification_visit_confirmed' => 'boolean',
            'notification_new_message'     => 'boolean',
        ]);

        Auth::user()->update($validated);

        return back()->with('success', 'Préférences mises à jour.');
    }

    /**
     * Déconnecter une session spécifique
     */
    public function logoutSession(Request $request, $sessionId)
    {
        if ($sessionId === session()->getId()) {
            Auth::logout();
            $request->session()->invalidate();
            return redirect('/login')->with('success', 'Session déconnectée.');
        }

        return back()->with('success', 'Session déconnectée.');
    }

    /**
     * Supprimer le compte utilisateur
     */
    public function deleteAccount(Request $request)
    {
        $request->validate(['password' => 'required|current_password']);

        $user = $request->user();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();

        return redirect('/')->with('success', 'Votre compte a été supprimé avec succès.');
    }

    /**
     * Exporter les données utilisateur (RGPD)
     */
    public function exportData()
    {
        $user = Auth::user();

        $data = [
            'profile'      => $user->only(['first_name', 'last_name', 'email', 'phone', 'created_at']),
            'properties'   => $user->properties->map(fn($p) => $p->only(['title', 'type', 'price', 'city', 'created_at'])),
            'appointments' => $user->appointments->map(fn($a) => $a->only(['visit_date', 'visit_time', 'status', 'created_at'])),
            'favorites'    => $user->favorites->map(fn($f) => $f->property->only(['title', 'type', 'price'])),
        ];

        $filename = 'user-data-' . $user->id . '-' . now()->format('Y-m-d') . '.json';

        return response(json_encode($data, JSON_PRETTY_PRINT))
            ->header('Content-Type', 'application/json')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Récupérer les sessions actives
     */
    private function getActiveSessions()
    {
        return [
            (object) [
                'id'            => session()->getId(),
                'device'        => $this->getUserDevice(),
                'ip_address'    => request()->ip(),
                'location'      => 'Votre emplacement actuel',
                'last_activity' => now(),
                'is_current'    => true,
            ]
        ];
    }

    /**
     * Détecter l'appareil utilisateur
     */
    private function getUserDevice()
    {
        $ua = request()->userAgent();
        if (str_contains($ua, 'Mobile')) return 'Mobile';
        if (str_contains($ua, 'Tablet')) return 'Tablet';
        return 'Desktop';
    }
}
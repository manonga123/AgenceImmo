<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\NotificationTrait;

class AppointmentController extends Controller
{
    use NotificationTrait;

    /**
     * Afficher les demandes de visite
     * → user : vue light (users.header)
     * → admin / owner : vue dark (layouts.layout)
     */
    public function index()
    {
        $user = Auth::user();

        $appointments = Appointment::with(['property', 'user', 'owner'])
            ->where(function ($query) {
                $query->where('user_id', Auth::id())
                      ->orWhereHas('property', function ($q) {
                          $q->where('owner_id', Auth::id());
                      });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if ($user->role === 'user') {
            return view('appointments.index', compact('appointments'));
        }

        return view('appointments.admin_index', compact('appointments'));
    }

    /**
     * Enregistrer une nouvelle demande de visite
     */
       public function store(Request $request, Property $property)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour effectuer une demande de visite.');
        }

        $validated = $request->validate([
            'visit_date' => 'required|date|after_or_equal:today',
            'visit_time' => 'required',
            'message'    => 'nullable|string|max:500',
        ]);

        if ($property->owner_id === Auth::id()) {
            return back()->with('error', 'Vous ne pouvez pas demander une visite pour votre propre propriété.');
        }

        $existingAppointment = Appointment::where('property_id', $property->id)
            ->where('visit_date', $validated['visit_date'])
            ->where('visit_time', $validated['visit_time'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->first();

        if ($existingAppointment) {
            return back()->with('error', 'Un rendez-vous existe déjà pour cette date et heure.');
        }

        try {
            $appointment = Appointment::create([
                'property_id' => $property->id,
                'user_id'     => Auth::id(),
                'owner_id'    => $property->owner_id,
                'visit_date'  => $validated['visit_date'],
                'visit_time'  => $validated['visit_time'],
                'message'     => $validated['message'] ?? null,
                'status'      => 'pending',
            ]);

            // Créer la notification pour nouveau rendez-vous
            $this->createNewAppointmentNotification($appointment, Auth::user(), $property);

            return back()->with('success', 'Votre demande de visite a été envoyée avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de l\'envoi de votre demande.');
        }
    }



    /**
     * Mettre à jour le statut d'une demande (confirmer / rejeter)
     * Seul le propriétaire de la propriété peut modifier le statut
     */
    public function update(Request $request, Appointment $appointment)
    {
        if ($appointment->property->owner_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cette demande.');
        }

        $request->validate([
            'status' => 'required|in:confirmed,rejected,cancelled',
        ]);

        $appointment->update(['status' => $request->status]);

        $statusMessages = [
            'confirmed' => 'Demande de visite confirmée.',
            'rejected'  => 'Demande de visite refusée.',
            'cancelled' => 'Demande de visite annulée.',
        ];

        return back()->with('success', $statusMessages[$request->status]);
    }

    /**
     * Accepter une demande (PATCH appointments/{id}/accept)
     */
     public function accept(Appointment $appointment)
    {
        if ($appointment->property->owner_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à accepter cette demande.');
        }

        $appointment->update(['status' => 'confirmed']);

        // Créer la notification pour confirmation de rendez-vous
        $this->createAppointmentConfirmedNotification($appointment, $appointment->property);

        return back()->with('success', 'Demande de visite confirmée.');
    }
    

    /**
     * Rejeter une demande (PATCH appointments/{id}/reject)
     */
    public function reject(Appointment $appointment)
    {
        if ($appointment->property->owner_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à refuser cette demande.');
        }

        $appointment->update(['status' => 'rejected']);

        // Créer la notification pour rejet de rendez-vous
        $this->createAppointmentRejectedNotification($appointment, $appointment->property);

        return back()->with('success', 'Demande de visite refusée.');
    }
    /**
     * Annuler une demande (pour l'utilisateur qui l'a créée)
     */
    public function destroy(Appointment $appointment)
    {
        if ($appointment->user_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à annuler cette demande.');
        }

        if (in_array($appointment->status, ['pending', 'confirmed'])) {
            $appointment->update(['status' => 'cancelled']);
            return back()->with('success', 'Demande de visite annulée avec succès.');
        }

        return back()->with('error', 'Impossible d\'annuler cette demande.');
    }

    /**
     * Demandes en attente
     * → user : vue light | admin/owner : vue dark
     */
    public function pendingRequests()
    {
        $user = Auth::user();

        $appointments = Appointment::with(['property', 'user', 'owner'])
            ->where('status', 'pending')
            ->where(function ($query) {
                $query->where('user_id', Auth::id())
                      ->orWhereHas('property', function ($q) {
                          $q->where('owner_id', Auth::id());
                      });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if ($user->role === 'user') {
            return view('appointments.pending', compact('appointments'));
        }

        return view('appointments.admin_pending', compact('appointments'));
    }

    /**
     * Demandes confirmées
     * → user : vue light | admin/owner : vue dark
     */
    public function confirmedRequests()
    {
        $user = Auth::user();

        $appointments = Appointment::with(['property', 'user', 'owner'])
            ->where('status', 'confirmed')
            ->where(function ($query) {
                $query->where('user_id', Auth::id())
                      ->orWhereHas('property', function ($q) {
                          $q->where('owner_id', Auth::id());
                      });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Pour chaque rendez-vous confirmé, on pourrait vérifier et notifier
        // Mais ce n'est pas ici qu'on confirme, donc pas de notification ici

        if ($user->role === 'user') {
            return view('appointments.confirmed', compact('appointments'));
        }

        return view('appointments.admin_confirmed', compact('appointments'));
    }


    /**
     * Afficher uniquement les demandes envoyées par l'utilisateur
     */
    public function myRequests()
    {
        $appointments = Appointment::with('property')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('appointments.my-requests', compact('appointments'));
    }

    /**
     * Afficher les demandes reçues pour les propriétés de l'utilisateur
     */
    public function receivedRequests()
    {
        $appointments = Appointment::with(['property', 'user'])
            ->whereHas('property', function ($query) {
                $query->where('owner_id', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('appointments.received-requests', compact('appointments'));
    }

    /**
     * Vérifier si l'utilisateur a déjà une demande pour une propriété
     */
    public function hasUserRequest(Property $property)
    {
        if (!Auth::check()) {
            return response()->json(['has_request' => false]);
        }

        $hasRequest = Appointment::where('property_id', $property->id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        return response()->json(['has_request' => $hasRequest]);
    }
}
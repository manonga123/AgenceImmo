<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Property;
use App\Models\Appointment;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    /**
     * Afficher le tableau de bord selon le rôle
     */
    public function index()
    {
        $user  = Auth::user();
        $stats = [];

        if ($user->role === 'admin') {
            $stats = $this->getAdminStats();
        } elseif ($user->role === 'owner') {
            $stats = $this->getOwnerStats($user->id);
        }

        $recentActivities   = $this->getRecentActivities($user);
        $recentAppointments = $this->getRecentAppointments($user);

        // ✅ Revenus mensuels filtrés selon le rôle
        $monthlyRevenue = [];
        if ($user->role === 'admin') {
            $monthlyRevenue = $this->getMonthlyRevenue();
        } elseif ($user->role === 'owner') {
            $monthlyRevenue = $this->getOwnerMonthlyRevenue($user->id);
        }

        $generatedAt = now()->format('d/m/Y à H:i');

        return view('dashboard', compact(
            'stats',
            'monthlyRevenue',
            'recentActivities',
            'recentAppointments',
            'user',
            'generatedAt'
        ));
    }

    /**
     * Exporter les statistiques en PDF (admin uniquement)
     */
    public function exportPdf()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $user  = Auth::user();
        $stats = $this->getAdminStats();

        $recentActivities   = $this->getRecentActivities($user);
        $recentAppointments = $this->getRecentAppointments($user);
        $monthlyRevenue     = $this->getMonthlyRevenue();
        $generatedAt        = now()->format('d/m/Y à H:i');

        $totalUsers    = User::where('role', 'user')->count();
        $totalOwners   = User::where('role', 'owner')->count();
        $totalAllUsers = $totalUsers + $totalOwners;

        $dispoVal = Property::where('status', 'disponible')->sum('price');
        $venduVal = Property::where('status', 'vendu')->sum('price');
        $loueVal  = Property::where('status', 'loué')->sum('price');

        $pdf = Pdf::loadView('pdf.dashboard-stats', compact(
            'stats',
            'monthlyRevenue',
            'recentActivities',
            'recentAppointments',
            'user',
            'generatedAt',
            'totalUsers',
            'totalOwners',
            'totalAllUsers',
            'dispoVal',
            'venduVal',
            'loueVal'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('statistiques-dashboard-' . now()->format('Y-m-d') . '.pdf');
    }

    // =============================================
    // STATISTIQUES ADMIN
    // =============================================
    private function getAdminStats(): array
    {
        $totalProperties       = Property::count();
        $availableProperties   = Property::where('status', 'disponible')->count();
        $soldProperties        = Property::where('status', 'vendu')->count();
        $rentedProperties      = Property::where('status', 'loué')->count();
        $totalUsers            = User::where('role', 'user')->count();
        $totalOwners           = User::where('role', 'owner')->count();
        $totalAppointments     = Appointment::count();
        $pendingAppointments   = Appointment::where('status', 'pending')->count();
        $confirmedAppointments = Appointment::where('status', 'confirmed')->count();
        $totalValue            = Property::sum('price');

        $newPropertiesThisMonth = Property::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $appointmentsThisMonth = Appointment::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return compact(
            'totalProperties',
            'availableProperties',
            'soldProperties',
            'rentedProperties',
            'totalUsers',
            'totalOwners',
            'totalAppointments',
            'pendingAppointments',
            'confirmedAppointments',
            'totalValue',
            'newPropertiesThisMonth',
            'appointmentsThisMonth'
        );
    }

    // =============================================
    // STATISTIQUES OWNER
    // =============================================
    private function getOwnerStats(int $ownerId): array
    {
        $myProperties        = Property::where('owner_id', $ownerId)->count();
        $myAvailable         = Property::where('owner_id', $ownerId)->where('status', 'disponible')->count();
        $mySold              = Property::where('owner_id', $ownerId)->where('status', 'vendu')->count();
        $myRented            = Property::where('owner_id', $ownerId)->where('status', 'loué')->count();
        $myTotalValue        = Property::where('owner_id', $ownerId)->sum('price');
        $myPendingVisits     = Appointment::where('owner_id', $ownerId)->where('status', 'pending')->count();
        $myConfirmedVisits   = Appointment::where('owner_id', $ownerId)->where('status', 'confirmed')->count();
        $myTotalAppointments = Appointment::where('owner_id', $ownerId)->count();

        $myNewThisMonth = Property::where('owner_id', $ownerId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // ✅ Ajout des clés normalisées pour la vue (donut chart)
        $totalProperties     = $myProperties;
        $availableProperties = $myAvailable;
        $soldProperties      = $mySold;
        $rentedProperties    = $myRented;

        return compact(
            'myProperties',
            'myAvailable',
            'mySold',
            'myRented',
            'myTotalValue',
            'myPendingVisits',
            'myConfirmedVisits',
            'myTotalAppointments',
            'myNewThisMonth',
            // ✅ Clés normalisées pour la vue partagée
            'totalProperties',
            'availableProperties',
            'soldProperties',
            'rentedProperties'
        );
    }

    // =============================================
    // REVENUS MENSUELS — ADMIN (table Revenue globale)
    // =============================================
    private function getMonthlyRevenue(): array
    {
        $revenue = \App\Models\Revenue::latest()->first();

        if (! $revenue) {
            return array_fill(0, 12, 0);
        }

        return [
            (float) $revenue->janvier,
            (float) $revenue->fevrier,
            (float) $revenue->mars,
            (float) $revenue->avril,
            (float) $revenue->mai,
            (float) $revenue->juin,
            (float) $revenue->juillet,
            (float) $revenue->aout,
            (float) $revenue->septembre,
            (float) $revenue->octobre,
            (float) $revenue->novembre,
            (float) $revenue->decembre,
        ];
    }

    // =============================================
    // ✅ REVENUS MENSUELS — OWNER
    // Somme des prix des propriétés vendues/louées
    // de l'owner, regroupées par mois (année en cours)
    // =============================================
    private function getOwnerMonthlyRevenue(int $ownerId): array
    {
        $rows = Property::where('owner_id', $ownerId)
            ->whereIn('status', ['vendu', 'loué'])
            ->whereYear('updated_at', now()->year)
            ->select(
                DB::raw('MONTH(updated_at) as month'),
                DB::raw('SUM(price) as total')
            )
            ->groupBy(DB::raw('MONTH(updated_at)'))
            ->pluck('total', 'month');

        $result = array_fill(0, 12, 0);
        foreach ($rows as $month => $total) {
            $result[$month - 1] = (float) $total;
        }

        return $result;
    }

    // =============================================
    // ACTIVITÉS RÉCENTES
    // =============================================
    private function getRecentActivities($user)
    {
        $query = Property::with('owner')
            ->orderBy('created_at', 'desc')
            ->limit(5);

        if ($user->role === 'owner') {
            $query->where('owner_id', $user->id);
        }

        return $query->get();
    }

    // =============================================
    // RENDEZ-VOUS RÉCENTS
    // =============================================
    private function getRecentAppointments($user)
    {
        $query = Appointment::with(['property', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5);

        if ($user->role === 'owner') {
            $query->where('owner_id', $user->id);
        } elseif ($user->role === 'user') {
            $query->where('user_id', $user->id);
        }

        return $query->get();
    }
}
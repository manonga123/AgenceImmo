<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Afficher toutes les notifications de l'utilisateur
     */
    public function index()
    {
        $user = Auth::user();

        $query = Notification::with(['emetteur', 'destinataire'])
            ->where(function ($q) use ($user) {
                if ($user->role === 'admin') {
                    $q->where('type', 'inscription')
                      ->orWhere(function ($sub) use ($user) {
                          $sub->where('id_destinataire', $user->id)
                              ->orWhere('id_emetteur', $user->id);
                      });
                } else {
                    $q->where(function ($sub) use ($user) {
                        $sub->where('id_destinataire', $user->id)
                            ->orWhere('id_emetteur', $user->id);
                    });
                }
            })
            ->orderBy('time', 'desc')
            ->paginate(20);

        return view('notifications.index', compact('query'));
    }

    /**
     * Récupérer les notifications non lues en temps réel (AJAX)
     */
   public function getUnreadNotifications()
{
    $user = Auth::user();

    $notifications = Notification::with(['emetteur'])
        ->where(function ($q) use ($user) {
            if ($user->role === 'admin') {
                $q->where('type', 'inscription')
                  ->orWhere(function ($sub) use ($user) {
                      $sub->where('id_destinataire', $user->id)
                          ->orWhere('id_emetteur', $user->id);
                  });
            } else {
                $q->where('id_destinataire', $user->id)
                  ->orWhere('id_emetteur', $user->id);
            }
        })
        ->where('read', false)
        ->orderBy('time', 'desc')
        ->limit(10)
        ->get();

    // ✅ Normalise les données pour le JS
    $data = $notifications->map(function ($n) {
        return [
            'id'      => $n->getKey(),   // récupère la clé primaire quelle que soit son nom
            'message' => $n->message,
            'type'    => $n->type,
            'read'    => $n->read,
            'time'    => $n->time ?? $n->created_at,
        ];
    });

    return response()->json([
        'notifications' => $data,
        'count'         => $notifications->count(),
    ]);
}

    /**
     * Marquer une notification comme lue
     */
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $user         = Auth::user();

        if ($notification->type === 'inscription' && $user->role !== 'admin') {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        if (
            $notification->id_destinataire != $user->id &&
            $notification->id_emetteur     != $user->id &&
            $user->role !== 'admin'
        ) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $notification->update(['read' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Notification marquée comme lue',
        ]);
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public function markAllAsRead()
    {
        $user = Auth::user();

        Notification::where(function ($q) use ($user) {
            if ($user->role === 'admin') {
                $q->where('type', 'inscription')
                  ->orWhere(function ($sub) use ($user) {
                      $sub->where('id_destinataire', $user->id)
                          ->orWhere('id_emetteur', $user->id);
                  });
            } else {
                $q->where('id_destinataire', $user->id)
                  ->orWhere('id_emetteur', $user->id);
            }
        })
        ->where('read', false)
        ->update(['read' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Toutes les notifications ont été marquées comme lues',
        ]);
    }

    /**
     * Supprimer une notification
     */
    public function destroy($id)
{
    $notification = Notification::findOrFail($id);
    $user         = Auth::user();

    if (
        $notification->id_destinataire != $user->id &&
        $notification->id_emetteur     != $user->id &&
        $user->role !== 'admin'
    ) {
        return response()->json(['error' => 'Non autorisé'], 403);
    }

    $notification->delete();

    return response()->json(['success' => true, 'message' => 'Notification supprimée']);
}

    /* ═══════════════════════════════════════════════════════
       MÉTHODES STATIQUES UTILITAIRES
    ═══════════════════════════════════════════════════════ */

    /**
     * Créer une notification (méthode utilitaire)
     */
    public static function createNotification($data)
    {
        $notification = Notification::create([
            'id_destinataire' => $data['destinataire_id'] ?? null,
            'id_emetteur'     => $data['emetteur_id']     ?? Auth::id(),
            'message'         => $data['message'],
            'type'            => $data['type'],
            'read'            => false,
        ]);

        return $notification;
    }

    /**
     * Notification pour nouvelle inscription (pour admin)
     */
    public static function newInscription($user)
    {
        $admins = \App\Models\User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            self::createNotification([
                'destinataire_id' => $admin->id,
                'emetteur_id'     => $user->id,
                'message'         => "Nouvelle inscription : {$user->name} ({$user->email})",
                'type'            => 'inscription',
            ]);
        }
    }

    /**
     * Notification pour nouveau produit
     */
    public static function newProduit($produit, $user)
    {
        $users = \App\Models\User::where('role', '!=', 'user')->get();

        foreach ($users as $destinataire) {
            if ($destinataire->id != $user->id) {
                self::createNotification([
                    'destinataire_id' => $destinataire->id,
                    'emetteur_id'     => $user->id,
                    'message'         => "Nouveau produit ajouté : {$produit->nom}",
                    'type'            => 'new_produits',
                ]);
            }
        }
    }

    /**
     * Notification pour nouveau rendez-vous
     */
    public static function newRendezVous($rendezVous, $user)
    {
        self::createNotification([
            'destinataire_id' => $rendezVous->property->user_id,
            'emetteur_id'     => $user->id,
            'message'         => "Nouvelle demande de rendez-vous pour {$rendezVous->property->titre}",
            'type'            => 'new_rendez_vous',
        ]);
    }

    /**
     * Notification pour confirmation de rendez-vous
     */
    public static function rendezVousConfirme($rendezVous, $user)
    {
        self::createNotification([
            'destinataire_id' => $rendezVous->user_id,
            'emetteur_id'     => $user->id,
            'message'         => "Votre rendez-vous pour {$rendezVous->property->titre} a été confirmé",
            'type'            => 'rendez_vous_confirme',
        ]);
    }

    /**
     * Notification pour rejet de rendez-vous
     */
    public static function rendezVousRejete($rendezVous, $user, $raison = null)
    {
        $message = "Votre rendez-vous pour {$rendezVous->property->titre} a été refusé";
        if ($raison) {
            $message .= " : {$raison}";
        }

        self::createNotification([
            'destinataire_id' => $rendezVous->user_id,
            'emetteur_id'     => $user->id,
            'message'         => $message,
            'type'            => 'rendez_vous_rejete',
        ]);
    }
}
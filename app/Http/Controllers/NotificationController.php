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
            ->where(function($q) use ($user) {
                // Pour les inscriptions, seul l'admin peut les voir
                if ($user->role === 'admin') {
                    $q->where('type', 'inscription')
                      ->orWhere(function($sub) use ($user) {
                          $sub->where('id_destinataire', $user->id)
                              ->orWhere('id_emetteur', $user->id);
                      });
                } else {
                    // Pour les autres utilisateurs, seulement leurs notifications
                    $q->where(function($sub) use ($user) {
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
            ->where(function($q) use ($user) {
                if ($user->role === 'admin') {
                    $q->where('type', 'inscription')
                      ->orWhere(function($sub) use ($user) {
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

        $count = $notifications->count();

        return response()->json([
            'notifications' => $notifications,
            'count' => $count,
            'html' => view('notifications.partials.notification-items', compact('notifications'))->render()
        ]);
    }

    /**
     * Marquer une notification comme lue
     */
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        
        // Vérifier les permissions
        $user = Auth::user();
        
        if ($notification->type === 'inscription' && $user->role !== 'admin') {
            return response()->json(['error' => 'Non autorisé'], 403);
        }
        
        if ($notification->id_destinataire != $user->id && $notification->id_emetteur != $user->id && $user->role !== 'admin') {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $notification->update(['read' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Notification marquée comme lue'
        ]);
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        
        $query = Notification::where(function($q) use ($user) {
            if ($user->role === 'admin') {
                $q->where('type', 'inscription')
                  ->orWhere(function($sub) use ($user) {
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
            'message' => 'Toutes les notifications ont été marquées comme lues'
        ]);
    }

    /**
     * Créer une notification (méthode utilitaire)
     */
    public static function createNotification($data)
    {
        return Notification::create([
            'id_destinataire' => $data['destinataire_id'] ?? null,
            'id_emetteur' => $data['emetteur_id'] ?? Auth::id(),
            'message' => $data['message'],
            'type' => $data['type'],
            'read' => false
        ]);
        broadcast(new \App\Events\NotificationCreated(
    $data['message'],
    $data['type'],
    $data['destinataire_id']
));
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
                'emetteur_id' => $user->id,
                'message' => "Nouvelle inscription : {$user->name} ({$user->email})",
                'type' => 'inscription'
            ]);
        }
    }

    /**
     * Notification pour nouveau produit
     */
    public static function newProduit($produit, $user)
    {
        // Notifier tous les utilisateurs intéressés ou admin
        $users = \App\Models\User::where('role', '!=', 'user')->get();
        
        foreach ($users as $destinataire) {
            if ($destinataire->id != $user->id) {
                self::createNotification([
                    'destinataire_id' => $destinataire->id,
                    'emetteur_id' => $user->id,
                    'message' => "Nouveau produit ajouté : {$produit->nom}",
                    'type' => 'new_produits'
                ]);
            }
        }
    }

    /**
     * Notification pour nouveau rendez-vous
     */
    public static function newRendezVous($rendezVous, $user)
    {
        // Notifier le propriétaire du bien
        self::createNotification([
            'destinataire_id' => $rendezVous->property->user_id,
            'emetteur_id' => $user->id,
            'message' => "Nouvelle demande de rendez-vous pour {$rendezVous->property->titre}",
            'type' => 'new_rendez_vous'
        ]);
    }

    /**
     * Notification pour confirmation de rendez-vous
     */
    public static function rendezVousConfirme($rendezVous, $user)
    {
        self::createNotification([
            'destinataire_id' => $rendezVous->user_id,
            'emetteur_id' => $user->id,
            'message' => "Votre rendez-vous pour {$rendezVous->property->titre} a été confirmé",
            'type' => 'rendez_vous_confirme'
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
            'emetteur_id' => $user->id,
            'message' => $message,
            'type' => 'rendez_vous_rejete'
        ]);
    }
}
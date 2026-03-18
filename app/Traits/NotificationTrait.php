<?php

namespace App\Traits;

use App\Models\Notification;
use App\Models\User;

trait NotificationTrait
{
    /**
     * Créer une notification d'inscription
     */
    protected function createInscriptionNotification($newUser)
    {
        // Notification pour les admins
        $admins = User::where('role', 'admin')->get();
        
        foreach ($admins as $admin) {
            Notification::create([
                'id_destinataire' => $admin->id,
                'id_emetteur' => $newUser->id,
                'message' => "Nouveau membre inscrit : {$newUser->first_name} {$newUser->last_name}",
                'type' => 'inscription',
                'read' => false,
                'time' => now()
            ]);
        }
    }

    /**
     * Créer une notification pour nouvelle propriété
     */
    protected function createNewPropertyNotification($property, $owner)
    {
        // Notification pour les admins
        $admins = User::where('role', 'admin')->get();
        
        foreach ($admins as $admin) {
            Notification::create([
                'id_destinataire' => $admin->id,
                'id_emetteur' => $owner->id,
                'message' => "Nouvelle propriété ajoutée : {$property->title} ({$property->type}) par {$owner->first_name} {$owner->last_name}",
                'type' => 'new_produits',
                'read' => false,
                'time' => now()
            ]);
        }
    }

    /**
     * Créer une notification pour nouveau rendez-vous
     */
    protected function createNewAppointmentNotification($appointment, $requester, $property)
    {
        // Notification pour le propriétaire
        Notification::create([
            'id_destinataire' => $property->owner_id,
            'id_emetteur' => $requester->id,
            'message' => "Nouvelle demande de rendez-vous pour votre propriété '{$property->title}' par {$requester->first_name} {$requester->last_name}",
            'type' => 'new_rendez_vous',
            'read' => false,
            'time' => now()
        ]);

        // Notification pour les admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'id_destinataire' => $admin->id,
                'id_emetteur' => $requester->id,
                'message' => "Nouvelle demande de rendez-vous pour la propriété '{$property->title}' par {$requester->first_name} {$requester->last_name}",
                'type' => 'new_rendez_vous',
                'read' => false,
                'time' => now()
            ]);
        }
    }

    /**
     * Créer une notification pour confirmation de rendez-vous
     */
    protected function createAppointmentConfirmedNotification($appointment, $property)
    {
        Notification::create([
            'id_destinataire' => $appointment->user_id,
            'id_emetteur' => $appointment->owner_id,
            'message' => "Votre demande de rendez-vous pour la propriété '{$property->title}' a été confirmée",
            'type' => 'rendez_vous_confirme',
            'read' => false,
            'time' => now()
        ]);
    }

    /**
     * Créer une notification pour rejet de rendez-vous
     */
    protected function createAppointmentRejectedNotification($appointment, $property)
    {
        Notification::create([
            'id_destinataire' => $appointment->user_id,
            'id_emetteur' => $appointment->owner_id,
            'message' => "Votre demande de rendez-vous pour la propriété '{$property->title}' a été refusée",
            'type' => 'rendez_vous_rejete',
            'read' => false,
            'time' => now()
        ]);
    }
    
}
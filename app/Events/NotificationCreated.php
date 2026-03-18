<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class NotificationCreated implements ShouldBroadcast
{
    use SerializesModels;

    public string $message;
    public string $type;
    public string $time;
    public int    $recipientId;

    public function __construct(string $message, string $type, int $recipientId)
    {
        $this->message     = $message;
        $this->type        = $type;
        $this->time        = now()->toIso8601String();
        $this->recipientId = $recipientId;
    }

    // Canal privé : chaque user écoute uniquement le sien
    public function broadcastOn(): array
    {
        return [new PrivateChannel('notifications.' . $this->recipientId)];
    }

    // Nom de l'événement reçu en JavaScript
    public function broadcastAs(): string
    {
        return 'notification.new';
    }
}
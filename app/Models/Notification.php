<?php
// app/Models/Notification.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $primaryKey = 'idnotification';

    protected $fillable = [
        'id_destinataire',
        'id_emetteur',
        'message',
        'read',
        'type',
        'time'
    ];

    protected $casts = [
        'read' => 'boolean',
        'time' => 'datetime'
    ];

    public function destinataire(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_destinataire');
    }

    public function emetteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_emetteur');
    }
}
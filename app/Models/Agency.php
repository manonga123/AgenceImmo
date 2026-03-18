<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $fillable = [
        'name',
        'siret',
        'address',
        'city',
        'postal_code',
        'phone',
        'email',
        'website',
        'description',
        'opening_hours',
        'logo_path',
        'sale_commission',
        'rental_commission',
        'vat_rate',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
        'sale_commission' => 'decimal:2',
        'rental_commission' => 'decimal:2',
        'vat_rate' => 'decimal:2',
    ];
}
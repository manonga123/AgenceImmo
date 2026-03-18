<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    protected $table = 'revenues';

    protected $fillable = [
        'janvier','fevrier','mars','avril','mai','juin',
        'juillet','aout','septembre','octobre','novembre','decembre',
    ];
}
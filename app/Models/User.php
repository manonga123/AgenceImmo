<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'role',
        'bio',
        'avatar_path',
        'account_holder',
        'iban',
        'bic',
        'bank_name',
        'auto_confirm_visits',
        'receive_visit_reminders',
        'max_response_time',
        'preferred_contact_method',
        'notification_preferences',
        'settings',
        'last_login_at',
        'email_verified_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'auto_confirm_visits' => 'boolean',
        'receive_visit_reminders' => 'boolean',
        'notification_preferences' => 'array',
        'settings' => 'array',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function properties()
    {
        return $this->hasMany(Property::class, 'owner_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    
        public function appointments()
    {
        return $this->hasMany(Appointment::class, 'user_id');
    }

    public function ownerAppointments()
    {
        return $this->hasMany(Appointment::class, 'owner_id');
    }

}


  // protected $fillable = [
    //     'first_name','last_name','email','phone','password','role'
    // ];
    
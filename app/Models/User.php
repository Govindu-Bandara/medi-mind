<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }

    public function requests()
    {
        return $this->hasMany(PatientRequest::class, 'patient_id');
    }
}
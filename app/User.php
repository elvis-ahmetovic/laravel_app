<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastname', 'username', 'email', 'password', 'city', 'image', 'role', 'admin_status',
    ];

    public function coach()
    {
        return $this->hasMany('App\Coach');
    }

    public function contact()
    {
        return $this->hasMany('App\Contact');
    }

    public function isSuperadmin() {
       return $this->role === 'superadmin';
    }

    public function isAdmin() {
       return $this->role === 'admin';
    }

    public function isUser() {
       return $this->role === 'user';
    }

    public function isCoach() {
       return $this->role === 'coach';
    }

    public function isVerifiedCoach() {
       return $this->role === 'verified_coach';
    }

    public function isBanned() {
       return $this->banned === 1;
    }
}

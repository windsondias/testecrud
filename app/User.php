<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'lastname', 'email', 'birthdate',
    ];

    public function addresses(){
        return $this->belongsToMany('App\Address', 'addresses_user');
    }

    public function phones(){
        return $this->belongsToMany('App\Phone', 'phones_user');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $fillable = [
        'zip', 'public_place', 'number', 'complement', 'district', 'city', 'state',
    ];

    public function users(){
        return $this->belongsToMany('App\User');
    }
}

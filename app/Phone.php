<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{

    protected $fillable = [
        'ddd', 'phone',
    ];

    public function users(){
        return $this->belongsToMany('App\User');
    }
}

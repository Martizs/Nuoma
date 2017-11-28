<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Photo extends Authenticatable
{
    protected $fillable = [
        'statusas', 'path'
    ];

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
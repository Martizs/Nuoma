<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Saskaita extends Authenticatable
{
    protected $fillable = [
        'metai', 'menesis', 'elektra','dujos', 'karstas', 'saltas', 'bendraSum', 'statusas', 'path'
    ];

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
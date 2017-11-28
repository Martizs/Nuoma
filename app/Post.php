<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'patalpuTipas', 'savivaldybe', 'gyvenviete','mikroRaj', 'gatve', 'plotas', 'komentaras','kaina', 'apsilankymas', 'post_history_id', 'ivertinimas'
    ];


    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function files()
    {
        return $this->hasMany('App\File');
    }

    public function but()
    {
        return $this->hasOne('App\But');
    }

    public function nam()
    {
        return $this->hasOne('App\Nam');
    }

    public function saskaitas()
    {
        return $this->hasMany('App\Saskaita');
    }

    public function photos()
    {
        return $this->hasMany('App\Photo');
    }
}
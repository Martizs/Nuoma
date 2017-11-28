<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'path', 'name', 'statusas', 'user_id'
    ];

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
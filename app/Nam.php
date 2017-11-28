<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nam extends Model
{
    protected $fillable = [
        'namoNr', 'pastatoTip', 'irengimoTip','sildymoTip', 'namoTip', 'metai'
    ];

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
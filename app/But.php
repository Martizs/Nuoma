<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class But extends Model
{
    protected $fillable = [
        'namoNr', 'butoNr', 'aukstas','kambSk', 'pastatoTip', 'irengimoTip', 'sildymoTip','metai'
    ];

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
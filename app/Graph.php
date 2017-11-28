<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

ini_set('max_execution_time', 300);

class Graph extends Model
{
    protected $fillable = [
        'diena', 'laikas', 'savaitesNr','statusas', 'user_id', 'nuomin_id', 'post_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
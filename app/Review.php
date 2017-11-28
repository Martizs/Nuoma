<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'statusas', 'atsiliepimas', 'user_id','rev_id', 'ivertinimas'
    ];

}
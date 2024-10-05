<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class usuario extends Model
{
     /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $fillable = [
        'emailL',
        'contra',
    ];
}


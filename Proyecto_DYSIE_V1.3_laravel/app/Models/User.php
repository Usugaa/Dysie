<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'password',
        'fecha_nacimiento',
        'grado',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
?>

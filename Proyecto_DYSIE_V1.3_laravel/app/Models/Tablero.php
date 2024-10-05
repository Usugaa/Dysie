<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tablero extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'nom_tablero', 'color'];

    public function tarjetas()
    {
        return $this->hasMany(Tarjeta::class, 'id_tablero');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarjeta extends Model
{
    use HasFactory;

    protected $fillable = ['id_tablero', 'nom_tarjeta', 'color'];

    public function tablero()
    {
        return $this->belongsTo(Tablero::class, 'id_tablero');
    }
}
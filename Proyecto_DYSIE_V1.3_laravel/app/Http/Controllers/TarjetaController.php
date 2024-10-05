<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarjeta;

class TarjetaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombre_tarjeta' => 'required',
            'color' => 'required',
            'tablero_id' => 'required',
        ]);

        Tarjeta::create([
            'nom_tarjeta' => $request->nombre_tarjeta,
            'color' => $request->color,
            'tablero_id' => $request->tablero_id,
        ]);

        return redirect()->route('dashboard');
    }

    public function destroy($id)
    {
        $tarjeta = Tarjeta::find($id);
        $tarjeta->delete();

        return redirect()->route('dashboard');
    }
}


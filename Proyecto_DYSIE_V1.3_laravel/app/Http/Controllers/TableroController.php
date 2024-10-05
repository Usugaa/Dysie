<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tablero;
use App\Models\User;

class TableroController extends Controller
{
        public function index()
        {
            $user = Auth::user();
    
            if (!$user) {
                return redirect()->route('login')->withErrors(['Debes iniciar sesión para acceder a esta página.']);
            }
    
            $tableros = Tablero::where('email', $user->email)->get();
            $membresia = User::where('email', $user->email)->value('membresia');
    
            $limite_tableros = $membresia ? 100 : 12;
            $num_tableros = $tableros->count();
    
            return view('dashboard', compact('tableros', 'limite_tableros', 'num_tableros'));
        }
    
        public function store(Request $request)
        {
            $user = Auth::user();
            $num_tableros = Tablero::where('email', $user->email)->count();
            $limite_tableros = $request->input('limite_tableros');
    
            if ($num_tableros < $limite_tableros) {
                Tablero::create([
                    'nom_tablero' => $request->input('nombre-tablero'),
                    'color' => $request->input('color-tablero'),
                    'email' => $user->email,
                ]);
    
                return redirect()->route('dashboard');
            }
    
            return redirect()->route('dashboard')->withErrors(['Has alcanzado el límite de tableros permitidos.']);
        }
    
    
    public function destroy($id)
    {
        $tablero = Tablero::find($id);
        $tablero->delete();

        return redirect()->route('dashboard');
    }
}

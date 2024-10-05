<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function login_post(Request $request)
    {
        $email = $request->input('txt_emailL');
        $password = $request->input('txt_contraseñaL');

        // Validar el email y la contraseña
        $credentials = ['email' => $email, 'password' => $password];

        if (Auth::attempt($credentials)) {
            // Inicio de sesión exitoso
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        // Fallo en el inicio de sesión, devolver mensaje de error
        return back()->withErrors(['error' => 'Correo o Contraseña Incorrectos']);
    }

    public function register_post(Request $request)
    {
        // Validar los datos del formulario de registro
        $validatedData = $request->validate([
            'txt_nombre' => 'required',
            'txt_apellido' => 'required',
            'txt_email' => 'required|email|unique:users,email',
            'txt_contra' => 'required|min:6',
            'confirma_contra' => 'required_with:txt_contra|same:txt_contra|min:6',
            'txt_fecha' => 'required|date',
            'select_grado' => 'required'
        ]);

        // Crear un nuevo usuario
        $user = new User();
        $user->nombre_usu = trim($request->txt_nombre);
        $user->apellidos_usu = trim($request->txt_apellido);
        $user->email = trim($request->txt_email);
        $user->password = Hash::make($request->txt_contra);
        $user->fecha_nacimiento = trim($request->txt_fecha);
        $user->grado = trim($request->select_grado);
        $user->remember_token = Str::random(50);
        $user->save();

        return redirect()->route('login')->with('success', 'Registro completado');
    }
}

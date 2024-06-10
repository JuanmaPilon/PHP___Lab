<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no son correctas, intenta nuevamente.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // Función para mostrar el formulario de registro
    public function showRegisterForm()
    {
        return view('register');
    }

    // Función para manejar el registro de usuarios
    public function register(Request $request)
    {
        $request->validate([
            'nombreUsuario' => 'required|string|max:255',
            'telefono' => 'required|numeric',
            'email' => 'required|string|email|max:255|unique:usuario',
            'password' => 'required|string|min:3|confirmed',
        ]);

        $user = Usuario::create([
            'nombreUsuario' => $request->nombreUsuario,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password' => Hash::make($request->password),
        ]);

        // Enviar email de verificación
        $user->sendEmailVerificationNotification();

        return redirect()->route('verification.notice');
    }
}

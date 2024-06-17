<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return response()->json($usuarios);
    }

    public function createUsuario(Request $request)
    {
        $request->validate([
            'nombreUsuario' => 'required|string|max:255',
            'telefono' => 'required|numeric',
            'email' => 'required|string|email|max:255|unique:usuario',
            'password' => 'required|string|min:3|confirmed',
        ]);

        $usuario = Usuario::create([
            'nombreUsuario' => $request->nombreUsuario,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Usuario creado correctamente', 'usuario' => $usuario]);
    }

    public function createAdmin(Request $request)
    {
        $request->validate([
            'nombreUsuario' => 'required|string|max:255',
            'telefono' => 'required|numeric',
            'email' => 'required|string|email|max:255|unique:usuario',
            'password' => 'required|string|min:3|confirmed',
        ]);
        
        $usuario = Usuario::create([
            'nombreUsuario' => $request->nombreUsuario,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password' => Hash::make($request->password),
        ]);

        Admin::create([
            'usuario_id' => $usuario->id,
        ]);

        return response()->json(['message' => 'Usuario administrador creado correctamente', 'usuario' => $usuario], 201);
    }

    public function showCreateUserForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombreUsuario' => 'required|string|max:255',
            'telefono' => 'required|numeric',
            'email' => 'required|string|email|max:255|unique:usuario',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Usuario::create([
            'nombreUsuario' => $request->nombreUsuario,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/');
    }
}

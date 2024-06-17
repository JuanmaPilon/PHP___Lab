<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    // Alta de cliente
    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'nombreUsuario' => 'required|string|unique:usuario,nombreUsuario',
            'password' => 'required|string|min:6',
            'telefono' => 'nullable|string',
            'email' => 'required|string|email|unique:usuario,email',
            'nombreNegocio' => 'required|string',
            'descripcion' => 'nullable|string',
        ]);

        // Crear un nuevo usuario
        $usuario = Usuario::create([
            'nombreUsuario' => $request->nombreUsuario,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'email' => $request->email,
        ]);

        // Crear un nuevo cliente asociado al usuario
        $cliente = Cliente::create([
            'usuario_id' => $usuario->id,
            'nombreNegocio' => $request->nombreNegocio,
            'descripcion' => $request->descripcion,
        ]);

        return response()->json(['message' => 'Cliente creado exitosamente', 'cliente' => $cliente], 201);
    }

    // Baja de cliente
    public function destroy($id)
    {
        // Buscar el cliente
        $cliente = Cliente::findOrFail($id);

        // Eliminar el usuario asociado (se eliminará automáticamente el cliente)
        $cliente->usuario->delete();

        return response()->json(['message' => 'Cliente eliminado exitosamente'], 200);
    }
}

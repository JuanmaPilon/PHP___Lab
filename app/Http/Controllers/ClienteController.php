<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{

    public function store(Request $request)
{
    $request->validate([
        'nombreUsuario' => 'required|string|unique:usuario',
        'password' => 'required|string|confirmed',
        'telefono' => 'nullable|string',
        'email' => 'required|string|email|unique:usuario',
        'nombreNegocio' => 'required|string',
        'descripcion' => 'nullable|string',
    ]);

    // Crear el usuario
    $usuario = Usuario::create([
        'nombreUsuario' => $request->nombreUsuario,
        'password' => Hash::make($request->password),
        'telefono' => $request->telefono,
        'email' => $request->email,
    ]);

    // Enviar notificación de verificación de email
    $usuario->sendEmailVerificationNotification();

    // Crear el cliente asociado al usuario
    Cliente::create([
        'usuario_id' => $usuario->id,
        'nombreNegocio' => $request->nombreNegocio,
        'descripcion' => $request->descripcion,
    ]);

    return redirect()->back()->with('success', 'Usuario creado correctamente');
}

    // Baja de cliente
    public function destroy($id)
    {
        // Buscar el cliente
        $cliente = Cliente::findOrFail($id);

        // Eliminar el usuario asociado (se eliminará automáticamente el cliente)
        $cliente->usuario->delete();

        return redirect()->back()->with('success', 'Cliente borrado exitosamente');
    }

    public function update(Request $request, $id)
    {
        // Validar la solicitud
        $request->validate([
            'nombreUsuario' => 'required|string',
            'telefono' => 'nullable|string',
            'email' => 'required|string|email',
            'nombreNegocio' => 'required|string',
            'descripcion' => 'nullable|string',
        ]);

        // Buscar el cliente
        $cliente = Cliente::findOrFail($id);
        $usuario = Usuario::findOrFail($cliente->usuario_id);

        // Actualizar el usuario
        $usuario->nombreUsuario = $request->input('nombreUsuario');
        $usuario->telefono = $request->input('telefono');
        $usuario->email = $request->input('email');
        $usuario->save();

        // Actualizar el cliente
        $cliente->nombreNegocio = $request->input('nombreNegocio');
        $cliente->descripcion = $request->input('descripcion');
        $cliente->save();

        return redirect()->back()->with('success', 'Cliente actualizado exitosamente');
    }

    // Obtener datos de un cliente por ID de cliente
    public function show($id)
    {
        try {
            // Buscar el cliente asociado al anuncio
            $cliente = Cliente::with('usuario')->findOrFail($id);
            return response()->json($cliente);
        } catch (\Exception $e) {
            // Registro de depuración
            \Log::error('Error al obtener datos del cliente: ' . $e->getMessage());
            return response()->json(['message' => 'Error al obtener datos del cliente.'], 500);
        }
    }
    public function getClientes()
    {
        $clientes = Cliente::with('usuario')->get();
        return response()->json($clientes);
    }
    public function showUsers()
    {
        $clientes = Cliente::with('usuario')->get();
        return view('listaUsuarios', compact('clientes'));
    }
    public function buscar($cliente_id)
    {
        $cliente = Cliente::findOrFail($cliente_id);
        return $cliente;
    }

}


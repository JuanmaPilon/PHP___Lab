<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    //
    public function list()
    {
        $usuarios = Usuario::all();
        if ($usuarios->isEmpty()) {
            $data = [
                'message' => 'no hay usuarios registrados',
                'status' => 200
            ];
            return response()->json($data, 200);
        }
        return response()->json($usuarios, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombreUsuario' => 'required',
            'contrasenia' => 'required',
            'telefono' => 'required',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $usuario = Usuario::create([
            'nombreUsuario' => $request->nombreUsuario,
            'contrasenia' => $request->contrasenia,
            'telefono' => $request->telefono,
            'email' => $request->email
        ]);

        if (!$usuario) {
            $data = [
                'message' => 'Error al crear el usuario',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
        $data  =[
            'usuario' => $usuario,
            'status' =>201 
        ];
        return response()->json($data, 201);
    }

}



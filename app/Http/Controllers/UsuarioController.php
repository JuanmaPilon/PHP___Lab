<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

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
            'nombreUsuario' => 'required|string|unique:usuarios',
            'nombreNegocio' => 'required|string',
            'telefono' => 'required|string',
            'email' => 'required|email|unique:usuarios',
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
            'password' => $request->password,
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
        $data = [
            'usuario' => $usuario,
            'status' => 201
        ];
        return response()->json($data, 201);
    }
    public function show($id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'usuario' => $usuario,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
    public function destroy($id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $usuario->delete();
        $data = [
            'message' => 'Usuario Eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
    public function update(Request $request, $id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $validator = Validator::make($request->all(), [
            'nombreUsuario' => 'required',
            'password' => 'required',
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

        $usuario->nombreUsuario = $request->nombreUsuario;
        $usuario->password = $request->password;
        $usuario->telefono = $request->telefono;
        $usuario->email = $request->email;

        $usuario->save();
        $data = [
            'message' => 'Usuario actualizado',
            'usuario' => $usuario,
            'status' => 200
        ];
        return response()->json($data, 200);

    }
    public function profile()
{
    $usuario = Auth::user();

    if ($usuario->admin) {
        return view('profile', ['usuario' => $usuario, 'admin' => $usuario->admin]);
    } else {
        return view('profile', ['usuario' => $usuario, 'cliente' => $usuario->cliente]);
    }
}



    public function recuperarContrasenia(Request $request)
    {
        $usuario = Usuario::where('email', $request->email)->first();

        if (!$usuario) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $plainPassword = $request->password;


        $usuario->password = $request->password;
        $usuario->save();


        $data = [
            'email' => $usuario->email,
            'nombre' => $usuario->nombreUsuario,
            'contrasenia' => $plainPassword // Usar 'contrasenia' en lugar de 'password'
        ];

        Mail::send('emails.recuperarContrasenia', $data, function ($message) use ($data) {
            $message->to($data['email'])
                ->subject('Recuperación de contraseña')
                ->from('revista@tallerphp.uy', 'Comercios y Servicios');
        });
        return redirect()->route('home')->with('success', 'Contraseña restablecida correctamente');
    }
}



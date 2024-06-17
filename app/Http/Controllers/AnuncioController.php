<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anuncio;

class AnuncioController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'cliente_id' => 'required|integer|exists:cliente,id',  // Asegúrate de que la tabla clientes existe o comenta esta línea
                'tipo' => 'required|string',
                'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imageName = time().'.'.$request->imagen->extension();
            $request->imagen->move(public_path('images'), $imageName);

            $anuncio = new Anuncio();
            $anuncio->cliente_id = $request->cliente_id;
            $anuncio->tipo = $request->tipo;
            $anuncio->disponible = $request->disponible;
            $anuncio->imagen = $imageName;
            $anuncio->save();

            return response()->json(['message' => 'Anuncio creado exitosamente'], 201);
        } catch (Exception $e) {
            Log::error('Error al crear anuncio: '.$e->getMessage());
            return response()->json(['error' => 'Error al crear anuncio'], 500);
        }
    }

    public function index()
    {
        $anuncios = Anuncio::all();
        return response()->json($anuncios, 200);
    }
}

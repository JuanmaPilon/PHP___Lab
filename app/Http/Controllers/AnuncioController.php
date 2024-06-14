<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anuncio;

class AnuncioController extends Controller
{
    // Método para guardar un anuncio con imagen
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|integer',
            'tipo' => 'required|string',
            'disponible' => 'required|boolean',
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
    }

    // Método para obtener todos los anuncios
    public function index()
    {
        $anuncios = Anuncio::all();
        return response()->json($anuncios, 200);
    }
}

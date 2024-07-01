<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anuncio;
use Illuminate\Support\Facades\Auth;

class AnuncioController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|integer|exists:cliente,id',
            'tipo' => 'required|string',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time() . '.' . $request->imagen->extension();
        $request->imagen->move(public_path('images'), $imageName);
        $anuncio = new Anuncio();
        $anuncio->cliente_id = $request->cliente_id;
        $anuncio->tipo = $request->tipo;
        $anuncio->disponible = $request->has('disponible');
        $anuncio->imagen = $imageName;
        $anuncio->save();
        return redirect()->route('anuncio.create')->with('success', 'Anuncio creado exitosamente');
    }

    public function index() //todos los anuncios para el admin
    {
        $anuncios = Anuncio::all();
        return view('index', compact('anuncios'));
    }

    public function anunciosDisponibles() // todos los anuncios DISPONIBLES para los visitantes
    {
        $anuncios = Anuncio::where('disponible', true)->get();
        return view('index', compact('anuncios'));
    }

    public function anunciosDisponiblesPorCliente($cliente_id)
    {
        $cliente = \App\Models\Cliente::findOrFail($cliente_id);
        $idabuscar = $cliente->id;      // o es id o es usuario_id
        $anuncios = Anuncio::where('cliente_id', $idabuscar)->where('disponible', true)->get();
        return view('index', compact('anuncios'));
    }


    public function showCreateAnuncioForm()
    {
        return view('anuncio');
    }
    public function destroy($id)
    {
        $anuncio = Anuncio::findOrFail($id);
        if (file_exists(public_path('images/' . $anuncio->imagen))) {
            unlink(public_path('images/' . $anuncio->imagen));
        }
        $anuncio->delete();
        return redirect()->route('anuncio.index')->with('success', 'Anuncio eliminado exitosamente');
    }
    public function toggleDisponibilidad($id) //alterna la disponibilidad del anuncio (solo para admin)
    {
        $anuncio = Anuncio::findOrFail($id);
        $anuncio->disponible = !$anuncio->disponible;
        $anuncio->save();
        return response()->json(['success' => true, 'message' => 'Estado de disponibilidad actualizado exitosamente']);
    }

    public function home()
{
    if (Auth::check()) {
        if (Auth::user()->admin) {
            return $this->index();
        } else {
            $cliente_id = Auth::user()->cliente->id;
            return $this->anunciosDisponiblesPorCliente($cliente_id);
        }
    } else {
        return $this->anunciosDisponibles();
    }
}

}


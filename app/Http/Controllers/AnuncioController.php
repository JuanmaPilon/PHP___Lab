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

    public function index(Request $request)
    {
        $query = $request->input('query');
        if ($query) {
            $anuncios = Anuncio::where('tipo', 'LIKE', "%{$query}%")->get();
        } else {
            $anuncios = Anuncio::all();
        }

        return view('index', compact('anuncios'));
    }

    public function anunciosDisponibles(Request $request)
    {
        $query = $request->input('query');
        if ($query) {
            $anuncios = Anuncio::where('disponible', true)
                               ->where('tipo', 'LIKE', "%{$query}%")
                               ->get();
        } else {
            $anuncios = Anuncio::where('disponible', true)->get();
        }

        return view('index', compact('anuncios'));
    }

    public function anunciosDisponiblesPorCliente(Request $request, $cliente_id)
    {
        $cliente = \App\Models\Cliente::findOrFail($cliente_id);
        $idabuscar = $cliente->id; // o es id o es usuario_id

        $query = $request->input('query');
        if ($query) {
            $anuncios = Anuncio::where('cliente_id', $idabuscar)
                               ->where('disponible', true)
                               ->where('tipo', 'LIKE', "%{$query}%")
                               ->get();
        } else {
            $anuncios = Anuncio::where('cliente_id', $idabuscar)
                               ->where('disponible', true)
                               ->get();
        }

        return view('index', compact('anuncios', 'cliente_id'));
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

    public function home(Request $request)
{
    if (Auth::check()) {
        if (Auth::user()->admin) {
            return $this->index($request); // Pasa el objeto Request a la función index
        } else {
            $cliente_id = Auth::user()->cliente->id;
            return $this->anunciosDisponiblesPorCliente($request, $cliente_id);
        }
    } else {
        return $this->anunciosDisponibles($request); // Pasa el objeto Request a la función anunciosDisponibles
    }
}
}



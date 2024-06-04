<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class HoroscopoController extends Controller
{
    public function getApiData()
    {
        $response = Http::get('https://horoscope-app-api.vercel.app/api/v1/get-horoscope/daily?sign=Scorpio&day=TODAY');
      
        if ($response->successful()) {
            $data = $response->json();

            return view('horoscopo', ['data' => $data['data']]);
        } else {
            // Manejo de errores
            return view('horoscopo', ['error' => 'Error al obtener datos de la API']);
        }
    }


}

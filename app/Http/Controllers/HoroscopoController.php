<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class HoroscopoController extends Controller
{
    public function getApiData(Request $request)
    {
        $sign = $request->input('sign', 'Aries');
        $day = $request->input('day', 'TODAY');

        $response = Http::get("https://horoscope-app-api.vercel.app/api/v1/get-horoscope/daily?sign={$sign}&day={$day}");

        if ($response->successful()) {
            $data = $response->json();

            return view('horoscopo', ['data' => $data['data']]);
        } else {
            // Manejo de errores
            return view('horoscopo', ['error' => 'Error al obtener datos de la API']);
        }
    }
}

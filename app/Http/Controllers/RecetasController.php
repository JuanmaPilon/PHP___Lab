<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RecetasController extends Controller
{
    public function getApiData(Request $request)
    {
        $ingredient = $request->input('query', 'Enchiladas');
        $apiKey = config('services.api_key');

        // Log para verificar la clave de API
        Log::info('Using API Key: ' . $apiKey);

        $response = Http::withHeaders([
            'X-Api-Key' => $apiKey,
        ])->get("https://api.api-ninjas.com/v1/recipe", [
            'query' => $ingredient
        ]);

        // Log para verificar el estado de la respuesta y el cuerpo
        Log::info('API Response Status: ' . $response->status());
        Log::info('API Response Body: ' . $response->body());

        if ($response->successful()) {
            $data = $response->json();

            // Log para verificar los datos obtenidos
            Log::info('API Response Data:', $data);

            return view('recetas', ['recipes' => $data]);
        } else {
            // Log para verificar el error
            Log::error('API Request Failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return view('recetas', [
                'recipes' => [],  // Asegúrate de pasar una variable `recipes` vacía
                'error' => 'No se pudo obtener los datos de la API.'
            ]);
        }
    }
}

<?php

use App\Http\Controllers\UsuarioController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HoroscopoController;
use App\Http\Controllers\RecetasController;

Route::get('listaUsuarios', [UsuarioController::class, 'showUsers']);
Route::get('usuarios', [UsuarioController::class, 'list']);
Route::post('usuarios', [UsuarioController::class, 'store']);   
Route::put('usuarios/{id}', [UsuarioController::class, 'update']);
Route::get('usuarios/{id}', [UsuarioController::class, 'show']);
Route::delete('usuarios/{id}', [UsuarioController::class, 'destroy']);
Route::get('horoscopo', [HoroscopoController::class, 'getApiData']);
Route::get('recetas', [RecetasController::class, 'getApiData']);



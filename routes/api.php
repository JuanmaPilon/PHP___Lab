<?php

use App\Http\Controllers\UsuarioController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HoroscopoController;
use App\Http\Controllers\RecetasController;
use App\Http\Controllers\AnuncioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;

Route::get('listaUsuarios', [UsuarioController::class, 'showUsers']);
Route::get('index', [AnuncioController::class, 'index']);

Route::get('usuarios', [UsuarioController::class, 'list']);
Route::post('usuarios', [UsuarioController::class, 'store']);   
Route::put('usuarios/{id}', [UsuarioController::class, 'update']);
Route::get('usuarios/{id}', [UsuarioController::class, 'show']);
Route::delete('usuarios/{id}', [UsuarioController::class, 'destroy']);
Route::get('horoscopo', [HoroscopoController::class, 'getApiData']);
Route::get('recetas', [RecetasController::class, 'getApiData']);

//AnuncioController
Route::post('/anuncios', [AnuncioController::class, 'store']);
Route::get('/anuncios', [AnuncioController::class, 'index']);

// las del admin controller
Route::middleware(['auth:api', 'can:manage-users'])->group(function () {
    Route::get('admin/users', [AdminController::class, 'index']);
    Route::post('admin/create', [AdminController::class, 'createAdmin']);
});

//las de ClienteController
Route::post('/clientes', [ClienteController::class, 'store']);
Route::delete('/clientes/{id}', [ClienteController::class, 'destroy']);

// Rutas de auth
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Perfil usuer
Route::get('/profile', [UsuarioController::class, 'profile'])->name('profile');
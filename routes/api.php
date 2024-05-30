<?php

use App\Http\Controllers\UsuarioController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

 
Route::get('admin',[AdminController::class, 'index']);

Route::get('/comerciosyservicios', function () {
    return view('index');
});

Route::get('/usuarios', [UsuarioController::class, 'list']);
Route::post('/usuarios', [UsuarioController::class, 'store']);
Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);
Route::get('/usuarios/{id}', [UsuarioController::class, 'show']);
Route::delete('usuarios/{id}', [UsuarioController::class, 'destroy']);
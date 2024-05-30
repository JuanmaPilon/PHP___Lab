<?php

use App\Http\Controllers\UsuarioController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('listaUsuarios', [UsuarioController::class, 'showUsers']);

    Route::get('usuarios', [UsuarioController::class, 'list']);
    Route::post('api/usuarios', [UsuarioController::class, 'store']);
    Route::put('api/usuarios/{id}', [UsuarioController::class, 'update']);
    Route::get('api/usuarios/{id}', [UsuarioController::class, 'show']);
    Route::delete('api/usuarios/{id}', [UsuarioController::class, 'destroy']);



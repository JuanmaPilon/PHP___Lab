<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;

Route::get('admin',[adminController::class, 'index']);

Route::get('/comerciosyservicios', function() {
    return 'Bienvenido a comercios y servicios';
});

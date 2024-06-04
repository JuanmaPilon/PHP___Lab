<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HoroscopoController;

Route::get('/', function () {
    return view('index');
});

Route::get('/recetas', function(){
    return view('recetas');
});
Route::get('/horoscopo',[HoroscopoController::class,'getapidata']);
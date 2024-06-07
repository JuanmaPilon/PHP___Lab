<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HoroscopoController;
use App\Http\Controllers\AuthController;

//LandingPage
Route::get('/', function () {
    return view('index');
});

//Recetas
Route::get('/recetas', function(){
    return view('recetas');
});

//Horoscopo
Route::get('/horoscopo',[HoroscopoController::class,'getapidata']);

//Auth Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

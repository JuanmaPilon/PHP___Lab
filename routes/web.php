<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HoroscopoController;
use App\Http\Controllers\RecetasController;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnuncioController;

//LandingPage
Route::get('/', function () {
    return view('index');
});
//anuncios
Route::get('/',[AnuncioController::class,'index']);

//Recetas
Route::get('/recetas', function(){
    return view('recetas');
});

//Horoscopo
Route::get('/horoscopo',[HoroscopoController::class,'getapidata']);
Route::get('/recetas', [RecetasController::class, 'getApiData']);

//Auth Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Email verify
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/resend', function (Request $request) {
    auth()->user()->sendEmailVerificationNotification();
    return back()->with('message', 'email enviado para verificar');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');


// Register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/create', [AdminController::class, 'showCreateUserForm'])->name('admin.create');
    Route::post('/admin/create', [AdminController::class, 'createUsuario']);
    Route::get('/admin/anuncio', [AnuncioController::class, 'showCreateAnuncioForm'])->name('anuncio.create');
    Route::post('/admin/anuncio', [AnuncioController::class, 'store']);
});



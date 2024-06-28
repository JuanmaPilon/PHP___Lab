<?php
use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HoroscopoController;
use App\Http\Controllers\RecetasController;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnuncioController;
use App\Http\Controllers\ContactController;

//LandingPage
Route::get('/', [AnuncioController::class, 'home'])->name('home');

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
    return view('verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['signed'])->name('verification.verify');

Route::get('/email/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Se ha reenviado el correo de verificación.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

// Register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

//datos clientes
Route::get('/cliente/{id}', [ClienteController::class, 'show']);
Route::get('/clientes', [ClienteController::class, 'getClientes']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/create', [AdminController::class, 'showCreateUserForm'])->name('admin.create');
    Route::post('/admin/create', [ClienteController::class, 'store']);
    Route::get('/admin/anuncio', [AnuncioController::class, 'showCreateAnuncioForm'])->name('anuncio.create');
    Route::post('/admin/anuncio', [AnuncioController::class, 'store']);
    Route::get('/admin/anuncios', [AnuncioController::class, 'index'])->name('anuncio.index');
    Route::delete('/admin/anuncio/{id}', [AnuncioController::class, 'destroy']);
    Route::get('/admin/listaUsuarios', [ClienteController::class, 'showUsers'])->name('clientes.lista');
    Route::delete('/admin/cliente/{id}', [ClienteController::class, 'destroy']);
    Route::patch('/admin/cliente/{id}', [ClienteController::class, 'update']);
    Route::post('/admin/anuncio/toggleDisponibilidad/{id}', [AnuncioController::class, 'toggleDisponibilidad'])->name('anuncio.toggleDisponibilidad');
});

// Perfil usuario
Route::get('/profile', [UsuarioController::class, 'profile'])->name('profile');

// Contacto
Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.form');
Route::post('/contact', [ContactController::class, 'sendMail'])->name('contact.send');

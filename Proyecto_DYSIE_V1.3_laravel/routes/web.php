<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController as AuthAuthenticatedSessionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TableroController;
use App\Http\Controllers\TarjetaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordResetController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/admin', function () {
    return view('admin');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login_post', [AuthController::class, 'login_post'])->name('login_post');

Route::post('/register_post', [AuthController::class, 'register_post'])->name('register_post');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [TableroController::class, 'index'])->name('dashboard');
    Route::post('/tableros', [TableroController::class, 'store'])->name('tableros.store');
    Route::post('/tarjetas', [TarjetaController::class, 'store'])->name('tarjetas.store');
    Route::delete('/tableros/{id}', [TableroController::class, 'destroy'])->name('tableros.destroy');
    Route::delete('/tarjetas/{id}', [TarjetaController::class, 'destroy'])->name('tarjetas.destroy');
    Route::post('logout', [AuthAuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::get('/recuperar', [PasswordResetController::class, 'showRecoverForm'])->name('password.request');
Route::post('/recuperar', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');

Route::fallback(function () {
    return view("error");
});

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
<<<<<<< HEAD
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PedidoController;


Route::resource('productos', ProductoController::class);
Route::get('/admin/dashboard', [UsuarioController::class, 'index'])->name('admin.dashboard');

// Rutas para que el administrador actualice roles o elimine usuarios
Route::put('/admin/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
Route::delete('/admin/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');


// Ruta del CRUD de Pedidos
Route::resource('pedidos', PedidoController::class);
=======
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('productos', ProductoController::class);
});
>>>>>>> origin/feature/auth-outlook-smtp

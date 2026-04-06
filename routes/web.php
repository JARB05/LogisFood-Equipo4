<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PedidoController;

// Si entran a la raíz, los mandamos a iniciar sesión
Route::get('/', function () {
    return redirect()->route('login');
});

// RUTAS PÚBLICAS 
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// RUTAS PROTEGIDAS (Solo entras si Auth::attempt funcionó)
Route::middleware('auth')->group(function () {
    
    // Cerrar sesión
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Catálogo y Pedidos (Por ahora sin el candado de CheckRol, solo exigimos que estén logueados)
    Route::resource('productos', ProductoController::class);
    Route::resource('pedidos', PedidoController::class);

    // Dashboard de Usuarios
    Route::get('/admin/dashboard', [UsuarioController::class, 'index'])->name('admin.dashboard');
    Route::put('/admin/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/admin/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
});
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PedidoController;

Route::get('/', function () {
    // Si el usuario YA inició sesión, lo mandamos a su panel
    if (Auth::check()) {
        $rolUsuario = Auth::user()->rol;
        
        if ($rolUsuario === 'Administrador') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('pedidos.index');
        }
    }
    
    // Si NO ha iniciado sesión, lo mandamos al login
    return redirect()->route('login');
});

// RUTAS PÚBLICAS (Solo para invitados) 
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
});

// RUTAS PROTEGIDAS (Solo entras si iniciaste sesión) 
Route::middleware('auth')->group(function () {
    
    // Cerrar sesión
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // PEDIDOS (Todos los roles pueden entrar)
    Route::middleware(['rol:Administrador,Empleado,Repartidor,Cliente'])->group(function () {
        Route::resource('pedidos', PedidoController::class);
    });

    // PRODUCTOS (Solo Admin y Empleado)
    Route::middleware(['rol:Administrador,Empleado'])->group(function () {
        Route::resource('productos', ProductoController::class);
    });

    // EXCLUSIVO DE ADMINISTRADORES (Dashboard de Usuarios)
    Route::middleware(['rol:Administrador'])->group(function () {
        Route::get('/admin/dashboard', [UsuarioController::class, 'index'])->name('admin.dashboard');
        Route::put('/admin/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('/admin/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
    });
});

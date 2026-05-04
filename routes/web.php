<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CarritoController;

Route::get('/', function () {
    if (Auth::check()) {
        $rolUsuario = Auth::user()->rol;
        if ($rolUsuario === 'Administrador') {
            return redirect()->route('admin.dashboard');
        } elseif ($rolUsuario === 'Cliente') {
            return redirect()->route('clientes.menu');
        } else {
            return redirect()->route('pedidos.index');
        }
    }
    return redirect()->route('login');
});

// ─── RUTAS PÚBLICAS (solo invitados) ─────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',           [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login',          [AuthController::class, 'login'])->name('login.attempt');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password',[AuthController::class, 'sendResetLink'])->name('password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password',        [AuthController::class, 'resetPassword'])->name('password.update');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register',[AuthController::class, 'register'])->name('register.store');
});

// ─── RUTAS PROTEGIDAS (sesión requerida) ──────────────────────────────────────
Route::middleware('auth')->group(function () {

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // PEDIDOS — todos los roles
    Route::middleware(['rol:Administrador,Empleado,Repartidor,Cliente'])->group(function () {
        Route::resource('pedidos', PedidoController::class);
    });

    // PRODUCTOS — Admin y Empleado
    Route::middleware(['rol:Administrador,Empleado'])->group(function () {
        Route::resource('productos', ProductoController::class);
        Route::resource('categorias', CategoriaController::class);
    });

    // MENÚ Y CARRITO — solo Clientes
    Route::middleware(['rol:Cliente'])->group(function () {
        Route::get('/menu',                                    [ProductoController::class, 'menu'])->name('clientes.menu');
        Route::get('/carrito',                                 [CarritoController::class, 'index'])->name('carrito.index');
        Route::post('/carrito/agregar/{id_producto}',          [CarritoController::class, 'agregar'])->name('carrito.agregar');
        Route::delete('/carrito/quitar/{id_detalle_carrito}',  [CarritoController::class, 'quitar'])->name('carrito.quitar');
    });

    // DASHBOARD DE ADMINISTRADOR
    Route::middleware(['rol:Administrador'])->group(function () {
        Route::get('/admin/dashboard',       [UsuarioController::class, 'index'])->name('admin.dashboard');
        Route::put('/admin/usuarios/{id}',   [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('/admin/usuarios/{id}',[UsuarioController::class, 'destroy'])->name('usuarios.destroy');
    });
});

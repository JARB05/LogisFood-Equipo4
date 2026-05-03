<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CategoriaController;

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

// [RUTA GLOBAL (Afuera de los middlewares para que cualquiera pueda ver la comida)
Route::get('/menu', [ProductoController::class, 'menu'])->name('productos.menu');

// RUTAS PÚBLICAS (Solo para invitados) 
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.attempt');
});

// RUTAS PROTEGIDAS (Solo entras si iniciaste sesión) 
Route::middleware('auth')->group(function () {
    
    // Cerrar sesión
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // PRODUCTOS (Solo Admin y Empleado pueden editar y borrar el catálogo)
    Route::middleware(['rol:Administrador,Empleado'])->group(function () {
     Route::resource('productos', ProductoController::class)->except(['show']); 
     Route::resource('categorias', CategoriaController::class); 
 });

    // EXCLUSIVO DE ADMINISTRADORES (Dashboard de Usuarios)
    Route::middleware(['rol:Administrador'])->group(function () {
        Route::get('/admin/dashboard', [UsuarioController::class, 'index'])->name('admin.dashboard');
        Route::put('/admin/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('/admin/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
    });

    // RUTAS DEL MOTOR DE VENTAS (CARRITO)
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::post('/carrito/eliminar', [CarritoController::class, 'eliminar'])->name('carrito.eliminar'); // [NUEVO]
    Route::post('/carrito/checkout', [CarritoController::class, 'procesarCheckout'])->name('carrito.checkout');

    // RUTAS DEL FLUJO DE PEDIDOS (MÁQUINA DE ESTADOS)
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::post('/pedidos/{pedido}/pagar', [PedidoController::class, 'pagar'])->name('pedidos.pagar');
    Route::post('/pedidos/{pedido}/preparar', [PedidoController::class, 'preparar'])->name('pedidos.preparar');
    Route::post('/pedidos/{pedido}/enviar', [PedidoController::class, 'enviar'])->name('pedidos.enviar');
    Route::post('/pedidos/{pedido}/entregar', [PedidoController::class, 'entregar'])->name('pedidos.entregar');
});
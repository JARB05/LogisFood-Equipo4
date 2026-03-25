<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaginasController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PedidoController;


Route::resource('productos', ProductoController::class);
Route::get('/admin/dashboard', [UsuarioController::class, 'index'])->name('admin.dashboard');

// Rutas para que el administrador actualice roles o elimine usuarios
Route::put('/admin/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
Route::delete('/admin/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');


// Ruta del CRUD de Pedidos
Route::resource('pedidos', PedidoController::class);

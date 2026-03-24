<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaginasController;
use App\Http\Controllers\ProductoController;

Route::resource('productos', ProductoController::class);

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaginasController;

Route::get('/', [PaginasController::class, 'index'])->name('index');
Route::get('/contacto', [PaginasController::class, 'contact'])->name('contact');
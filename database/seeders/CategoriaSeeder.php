<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        Categoria::create(['nombre' => 'Plato Fuerte']);
        Categoria::create(['nombre' => 'Guarnición']);
        Categoria::create(['nombre' => 'Bebidas']);
    }
}
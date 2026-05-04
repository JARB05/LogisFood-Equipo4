<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        Producto::create([
            'id_producto' => 'PROD-001',
            'nombre' => 'Hamburguesa Clásica',
            'imagen_url' => 'https://via.placeholder.com/150',
            'precio' => 120.50,
            'id_categoria' => 1 
        ]);

        Producto::create([
            'id_producto' => 'PROD-002',
            'nombre' => 'Papas a la Francesa',
            'imagen_url' => 'https://via.placeholder.com/150',
            'precio' => 45.00,
            'id_categoria' => 2 
        ]);

        Producto::create([
            'id_producto' => 'PROD-003',
            'nombre' => 'Refresco de Cola',
            'imagen_url' => 'https://via.placeholder.com/150',
            'precio' => 25.00,
            'id_categoria' => 3 
        ]);
    }
}
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
            'precio' => 120.50,
            'categoria' => 'Plato Fuerte'
        ]);

        Producto::create([
            'id_producto' => 'PROD-002',
            'nombre' => 'Papas a la Francesa',
            'precio' => 45.00,
            'categoria' => 'Guarnición'
        ]);

        Producto::create([
            'id_producto' => 'PROD-003',
            'nombre' => 'Refresco de Cola',
            'precio' => 25.00,
            'categoria' => 'Bebidas'
        ]);
    }
}
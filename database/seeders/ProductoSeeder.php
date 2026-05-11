<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        // Catálogo de productos con FOTOGRAFÍAS REALES de alta calidad de Unsplash
        $productos = [
            // --- PLATOS FUERTES (Categoría 1) ---
            ['nombre' => 'Bife de Chorizo (400g)', 'precio' => 490.00, 'categoria' => 1, 'stock' => 25, 'imagen' => 'https://images.unsplash.com/photo-1594041680534-e8c8cdebd659?w=600&q=80'],
            ['nombre' => 'Vacío Argentino (400g)', 'precio' => 420.00, 'categoria' => 1, 'stock' => 30, 'imagen' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=600&q=80'],
            ['nombre' => 'Arrachera Marinada (300g)', 'precio' => 380.00, 'categoria' => 1, 'stock' => 40, 'imagen' => 'https://images.unsplash.com/photo-1558030006-450675393462?w=600&q=80'],
            ['nombre' => 'Ribeye Calidad Angus (400g)', 'precio' => 650.00, 'categoria' => 1, 'stock' => 20, 'imagen' => 'https://images.unsplash.com/photo-1600891964092-4316c288032e?w=600&q=80'],
            ['nombre' => 'Milanesa Napolitana de Res', 'precio' => 240.00, 'categoria' => 1, 'stock' => 35, 'imagen' => 'https://images.unsplash.com/photo-1626645738196-c2a7c87a8f58?w=600&q=80'],
            ['nombre' => 'Pechuga de Pollo a la Parrilla', 'precio' => 190.00, 'categoria' => 1, 'stock' => 50, 'imagen' => 'https://images.unsplash.com/photo-1598514982205-f36b96d1e8d4?w=600&q=80'],
            ['nombre' => 'Salmón a la Parrilla con Finas Hierbas', 'precio' => 320.00, 'categoria' => 1, 'stock' => 20, 'imagen' => 'https://images.unsplash.com/photo-1485921325833-c519f76c4927?w=600&q=80'],
            ['nombre' => 'Fettuccine Alfredo con Pollo', 'precio' => 210.00, 'categoria' => 1, 'stock' => 30, 'imagen' => 'https://images.unsplash.com/photo-1645112411341-6c4fd023714a?w=600&q=80'],
            ['nombre' => 'Hamburguesa Argentina (Queso y Chorizo)', 'precio' => 260.00, 'categoria' => 1, 'stock' => 40, 'imagen' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=600&q=80'],
            ['nombre' => 'Choripán Clásico', 'precio' => 150.00, 'categoria' => 1, 'stock' => 45, 'imagen' => 'https://images.unsplash.com/photo-1629555621876-0bfdc556858e?w=600&q=80'],

            // --- GUARNICIONES Y ENTRADAS (Categoría 2) ---
            ['nombre' => 'Empanada de Carne Cortada a Cuchillo', 'precio' => 65.00, 'categoria' => 2, 'stock' => 80, 'imagen' => 'https://images.unsplash.com/photo-1626200419188-f1a16442f7fb?w=600&q=80'],
            ['nombre' => 'Empanada de Elote con Queso', 'precio' => 60.00, 'categoria' => 2, 'stock' => 70, 'imagen' => 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=600&q=80'],
            ['nombre' => 'Queso Provoleta Asado', 'precio' => 180.00, 'categoria' => 2, 'stock' => 30, 'imagen' => 'https://images.unsplash.com/photo-1598215439218-f79b4ed21f6a?w=600&q=80'],
            ['nombre' => 'Chorizo Argentino (1 Pieza)', 'precio' => 85.00, 'categoria' => 2, 'stock' => 60, 'imagen' => 'https://images.unsplash.com/photo-1529692236671-f1f6cf9683ba?w=600&q=80'],
            ['nombre' => 'Jugo de Carne Tradicional', 'precio' => 120.00, 'categoria' => 2, 'stock' => 40, 'imagen' => 'https://images.unsplash.com/photo-1547592180-85f173990554?w=600&q=80'],
            ['nombre' => 'Papas a la Francesa', 'precio' => 70.00, 'categoria' => 2, 'stock' => 100, 'imagen' => 'https://images.unsplash.com/photo-1576107232684-1279f390859f?w=600&q=80'],
            ['nombre' => 'Puré de Papa Rústico', 'precio' => 80.00, 'categoria' => 2, 'stock' => 50, 'imagen' => 'https://images.unsplash.com/photo-1628198759020-f5a004f14a6d?w=600&q=80'],
            ['nombre' => 'Espinacas a la Crema', 'precio' => 95.00, 'categoria' => 2, 'stock' => 45, 'imagen' => 'https://images.unsplash.com/photo-1582234372722-50d7ccc30ebd?w=600&q=80'],
            ['nombre' => 'Ensalada Mixta (Lechuga, Tomate, Cebolla)', 'precio' => 110.00, 'categoria' => 2, 'stock' => 60, 'imagen' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=600&q=80'],
            ['nombre' => 'Espárragos a la Parrilla', 'precio' => 130.00, 'categoria' => 2, 'stock' => 35, 'imagen' => 'https://images.unsplash.com/photo-1425136738262-212551713a58?w=600&q=80'],

            // --- BEBIDAS (Categoría 3) ---
            ['nombre' => 'Refresco de Cola 355ml', 'precio' => 45.00, 'categoria' => 3, 'stock' => 200, 'imagen' => 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?w=600&q=80'],
            ['nombre' => 'Limonada Mineral 400ml', 'precio' => 55.00, 'categoria' => 3, 'stock' => 150, 'imagen' => 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=600&q=80'],
            ['nombre' => 'Naranjada Natural 400ml', 'precio' => 55.00, 'categoria' => 3, 'stock' => 120, 'imagen' => 'https://images.unsplash.com/photo-1600271886742-f049cd451b02?w=600&q=80'],
            ['nombre' => 'Agua Mineral 355ml', 'precio' => 40.00, 'categoria' => 3, 'stock' => 150, 'imagen' => 'https://images.unsplash.com/photo-1560508180-03f285f67dee?w=600&q=80'],
            ['nombre' => 'Cerveza Nacional 355ml', 'precio' => 65.00, 'categoria' => 3, 'stock' => 180, 'imagen' => 'https://images.unsplash.com/photo-1608270586620-248524c67de9?w=600&q=80'],
            ['nombre' => 'Copa de Vino Tinto (Malbec)', 'precio' => 140.00, 'categoria' => 3, 'stock' => 50, 'imagen' => 'https://images.unsplash.com/photo-1506377247377-2a5b3b417ebb?w=600&q=80'],
            ['nombre' => 'Botella de Vino Tinto (Malbec Reserva)', 'precio' => 650.00, 'categoria' => 3, 'stock' => 25, 'imagen' => 'https://images.unsplash.com/photo-1584916201218-f4242ceb4809?w=600&q=80'],
            ['nombre' => 'Café Americano', 'precio' => 45.00, 'categoria' => 3, 'stock' => 100, 'imagen' => 'https://images.unsplash.com/photo-1497935586351-b67a49e012bf?w=600&q=80'],
            ['nombre' => 'Café Capuchino', 'precio' => 65.00, 'categoria' => 3, 'stock' => 80, 'imagen' => 'https://images.unsplash.com/photo-1534040385115-33dcb3acba5b?w=600&q=80'],
        ];

        // Insertar a la base de datos
        foreach ($productos as $index => $prod) {
            $id_formateado = 'PROD-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);

            Producto::create([
                'id_producto'  => $id_formateado,
                'nombre'       => $prod['nombre'],
                'imagen_url'   => $prod['imagen'], // <-- Regresamos a las URLs de Unsplash
                'precio'       => $prod['precio'],
                'stock'        => $prod['stock'],
                'id_categoria' => $prod['categoria']
            ]);
        }
    }
}
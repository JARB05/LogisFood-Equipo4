<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pedido;
use Carbon\Carbon;

class PedidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pedido 1: Recién creado por el cliente
        Pedido::create([
            'id_pedido' => 'PED-0001',
            'id_cliente' => 'USR-CLI01', // Oliver
            'id_repartidor' => null,
            'fecha' => Carbon::now(),
            'total' => 250.50,
            'estado' => 'Creado',
            'tipo_entrega' => 'Domicilio'
        ]);

        // Pedido 2: Ya está en camino 
        Pedido::create([
            'id_pedido' => 'PED-0002',
            'id_cliente' => 'USR-CLI01',
            'id_repartidor' => 'USR-REP01', // Joel
            'fecha' => Carbon::now()->subMinutes(45), // Hace 45 minutos
            'total' => 480.00,
            'estado' => 'En Camino',
            'tipo_entrega' => 'Domicilio'
        ]);

        // Pedido 3: Un pedido histórico para consumo local en sucursal
        Pedido::create([
            'id_pedido' => 'PED-0003',
            'id_cliente' => 'USR-CLI01',
            'id_repartidor' => null, // No ocupa repartidor porque es local
            'fecha' => Carbon::now()->subDays(2), // Hace 2 días
            'total' => 120.00,
            'estado' => 'Entregado',
            'tipo_entrega' => 'Local'
        ]);
    }
}

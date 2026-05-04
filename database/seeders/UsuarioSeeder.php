<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        /*Tres usuarios manuales fijos*/
        Usuario::create([
            'id_usuario' => 'USR-ADMIN01',
            'nombre' => 'Pedro Sánchez',
            'email' => 'pedro.sanchez@miproyecto.com',
            'password_hash' => Hash::make('p3Dr054nchez'),
            'direccion' => 'Oficina Central',
            'rol' => 'Administrador'
        ]);

        Usuario::create([
            'id_usuario' => 'USR-CLI01',
            'nombre' => 'Oliver Salazar',
            'email' => 'oliver@correo.com',
            'password_hash' => Hash::make('cliente123'),
            'direccion' => 'Campus Tecmilenio',
            'rol' => 'Cliente'
        ]);

        Usuario::create([
            'id_usuario' => 'USR-REP01',
            'nombre' => 'Joel Bojórquez',
            'email' => 'repartidor@logisfood.com',
            'password_hash' => Hash::make('moto123'),
            'direccion' => 'Base LogisFood',
            'rol' => 'Repartidor'
        ]);

        /*Nuevo usuario empleado*/
        Usuario::create([
            'id_usuario' => 'USR-EMP01',
            'nombre' => 'Carlos Cocina',
            'email' => 'empleado@logisfood.com',
            'password_hash' => Hash::make('empleado123'),
            'direccion' => 'Cocina Central LogisFood',
            'rol' => 'Empleado'
        ]);

        /*Nuevos empleados aleatorios */
        Usuario::factory()->count(5)->create([
            'rol' => 'Empleado'
        ]);

        /*5 Administradores aleatorios*/
        Usuario::factory()->count(5)->create([
            'rol' => 'Administrador'
        ]);

        /*50 clientes aleatorios*/
        Usuario::factory()->count(50)->create([
            'rol' => 'Cliente'
        ]);
    }
}
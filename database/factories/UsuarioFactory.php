<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition(): array
    {
        return [
            'id_usuario' => 'USR-' . strtoupper(Str::random(10)), 
            'nombre' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password_hash' => Hash::make('test123'), 
            'direccion' => fake()->address(),
            'rol' => 'Cliente', // Rol por defecto
        ];
    }
}
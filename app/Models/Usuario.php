<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    // Configuración de Llave Primaria
    protected $primaryKey = 'id_usuario';
    public $incrementing = false;
    protected $keyType = 'string';

    // Campos permitidos para asignación masiva
    protected $fillable = [
        'id_usuario', 'nombre', 'email', 'password_hash', 'direccion', 'rol'
    ];

    // Relación 1:N (Un usuario realiza múltiples pedidos)
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_cliente', 'id_usuario');
    }

    // Relación 1:N (Un usuario puede tener carritos)
    public function carritos()
    {
        return $this->hasMany(Carrito::class, 'id_usuario', 'id_usuario');
    }
}
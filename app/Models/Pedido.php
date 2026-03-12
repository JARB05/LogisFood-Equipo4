<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $primaryKey = 'id_pedido';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pedido', 'id_cliente', 'id_repartidor', 'fecha', 'total', 'estado', 'tipo_entrega'
    ];

    // Relación Inversa (Un pedido pertenece a un cliente)
    public function cliente()
    {
        return $this->belongsTo(Usuario::class, 'id_cliente', 'id_usuario');
    }

    public function repartidor()
    {
        return $this->belongsTo(Usuario::class, 'id_repartidor', 'id_usuario');
    }

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'id_pedido', 'id_pedido');
    }
}
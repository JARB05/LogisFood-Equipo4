<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $primaryKey = 'id_producto';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_producto', 'nombre', 'precio', 'categoria'
    ];

    public function detallesPedido()
    {
        return $this->hasMany(DetallePedido::class, 'id_producto', 'id_producto');
    }
}
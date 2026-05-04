<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        // Traemos todos los pedidos por ahora, ordenados por los más recientes
        $pedidos = Pedido::orderBy('fecha', 'desc')->get();
        
        return view('pedidos.index', compact('pedidos'));
    }

}
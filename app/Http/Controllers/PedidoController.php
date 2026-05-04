<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        $query = Pedido::with('detalles.producto');

        if ($usuario->rol === 'Cliente') {
            $pedidos = $query->where('id_cliente', $usuario->id_usuario)->latest('fecha')->get();
        } elseif ($usuario->rol === 'Repartidor') {
            $pedidos = $query->where('id_repartidor', $usuario->id_usuario)->latest('fecha')->get();
        } else {
            $pedidos = $query->latest('fecha')->get();
        }

        return view('pedidos.index', compact('pedidos'));
    }

    public function pagar($id) 
    {
        $pedido = Pedido::where('id_pedido', $id)->firstOrFail(); 

        if ($pedido->id_cliente !== Auth::user()->id_usuario || $pedido->estado !== 'Creado') {
            return back()->withErrors('Acción no permitida o el pedido ya fue pagado.');
        }

        $pedido->update(['estado' => 'Pagado']);
        return back()->with('success', 'Pago procesado. Tu pedido pasará a cocina pronto.');
    }

    public function preparar($id) 
    {
        $pedido = Pedido::where('id_pedido', $id)->firstOrFail();

        if ($pedido->estado !== 'Pagado') {
            return back()->withErrors('No puedes preparar un pedido que no ha sido pagado.');
        }

        $pedido->update(['estado' => 'En Preparación']);
        return back()->with('success', 'El pedido está ahora en cocina.');
    }

    public function enviar(Request $request, $id) 
    {
        $request->validate([
            'id_repartidor' => 'required|exists:usuarios,id_usuario'
        ]);

        $pedido = Pedido::where('id_pedido', $id)->firstOrFail();

        if ($pedido->estado !== 'En Preparación') {
            return back()->withErrors('El pedido debe estar preparado antes de enviarse.');
        }

        $pedido->update([
            'estado' => 'En Camino',
            'id_repartidor' => $request->id_repartidor
        ]);

        return back()->with('success', 'Pedido enviado con el repartidor.');
    }

    public function entregar($id) 
    {
        $pedido = Pedido::where('id_pedido', $id)->firstOrFail();

        if ($pedido->id_repartidor !== Auth::user()->id_usuario || $pedido->estado !== 'En Camino') {
            return back()->withErrors('No tienes permiso para entregar este pedido o aún no está en camino.');
        }

        $pedido->update(['estado' => 'Entregado']);
        return back()->with('success', '¡Pedido entregado con éxito! Misión cumplida.');
    }
}
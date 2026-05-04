<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\DetalleCarrito;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = Carrito::firstOrCreate(['id_usuario' => Auth::user()->id_usuario]);
        $detalles = DetalleCarrito::with('producto')->where('id_carrito', $carrito->id_carrito)->get();
        return view('carrito.index', compact('carrito', 'detalles'));
    }

    public function agregar(Request $request)
    {
        $request->validate([
            'id_producto' => 'required|exists:productos,id_producto',
            'cantidad' => 'required|integer|min:1'
        ]);

        $producto = Producto::findOrFail($request->id_producto);
        $carrito = Carrito::firstOrCreate(['id_usuario' => Auth::user()->id_usuario]);

        $detalle = DetalleCarrito::where('id_carrito', $carrito->id_carrito)
                                 ->where('id_producto', $request->id_producto)
                                 ->first();

        $cantidadActualEnCarrito = $detalle ? $detalle->cantidad : 0;
        if (($cantidadActualEnCarrito + $request->cantidad) > $producto->stock) {
            return back()->withErrors("No hay suficiente stock. Solo quedan {$producto->stock} unidades de {$producto->nombre}.");
        }

        if ($detalle) {
            $detalle->cantidad += $request->cantidad;
            $detalle->save();
        } else {
            DetalleCarrito::create([
                'id_carrito' => $carrito->id_carrito,
                'id_producto' => $request->id_producto,
                'cantidad' => $request->cantidad
            ]);
        }

        $carrito->touch('ultima_actualizacion');
        return back()->with('success', 'Producto agregado al carrito.');
    }

    public function procesarCheckout(Request $request)
    {
        $request->validate([
            'tipo_entrega' => 'nullable|string|in:Local,Domicilio' 
        ]);

        $carrito = Carrito::firstOrCreate(['id_usuario' => Auth::user()->id_usuario]);
        $detalles = DetalleCarrito::with('producto')->where('id_carrito', $carrito->id_carrito)->get();

        if ($detalles->isEmpty()) {
            return back()->withErrors('Tu carrito está vacío.');
        }

        DB::beginTransaction();

        try {
            $total = 0;
            $nuevoIdPedido = 'PED-' . strtoupper(Str::random(6));

            foreach ($detalles as $item) {
                if ($item->cantidad > $item->producto->stock) {
                    throw new \Exception("El producto '{$item->producto->nombre}' se quedó sin stock suficiente. Por favor, actualiza tu carrito.");
                }
                $total += ($item->producto->precio * $item->cantidad);
            }

            $pedido = Pedido::create([
                'id_pedido' => $nuevoIdPedido,
                'id_cliente' => Auth::user()->id_usuario,
                'fecha' => now(),
                'total' => $total,
                'estado' => 'Creado',
                'tipo_entrega' => $request->input('tipo_entrega', 'Local')
            ]);

            foreach ($detalles as $item) {
                DetallePedido::create([
                    'id_pedido' => $pedido->id_pedido,
                    'id_producto' => $item->id_producto,
                    'cantidad' => $item->cantidad,
                    'precio_unitario' => $item->producto->precio 
                ]);

                $item->producto->decrement('stock', $item->cantidad);
            }

            DetalleCarrito::where('id_carrito', $carrito->id_carrito)->delete();
            DB::commit();

            return redirect()->route('pedidos.index')->with('success', '¡Tu pedido '.$nuevoIdPedido.' ha sido generado con éxito!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Error al procesar el pedido: ' . $e->getMessage());
        }
    }

    public function eliminar(Request $request)
    {
        $request->validate([
            'id_producto' => 'required|exists:productos,id_producto'
        ]);

        $carrito = Carrito::where('id_usuario', Auth::user()->id_usuario)->first();

        if ($carrito) {
            DetalleCarrito::where('id_carrito', $carrito->id_carrito)
                          ->where('id_producto', $request->id_producto)
                          ->delete();
                          
            $carrito->touch('ultima_actualizacion');
        }

        return back()->with('success', 'Producto retirado del carrito.');
    }
}
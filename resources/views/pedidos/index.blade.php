<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pedidos</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 40px; margin: 0; }
        .contenedor { max-width: 1100px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background-color: #f9fafb; font-weight: bold; }
        .badge { padding: 4px 8px; border-radius: 12px; font-size: 0.85em; font-weight: bold; }
        .badge-creado { background: #e0f2fe; color: #0284c7; }
        .badge-preparacion { background: #fef08a; color: #854d0e; }
        .badge-camino { background: #fed7aa; color: #c2410c; }
        .badge-entregado { background: #dcfce7; color: #166534; }
        select { padding: 6px; border-radius: 4px; border: 1px solid #ccc; }
        .btn-guardar { background: #3b82f6; color: white; border: none; padding: 6px 10px; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="contenedor">
        <h1>Órdenes y Pedidos</h1>
        
        <table>
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Entrega</th>
                    <th>Estado Actual</th>
                    <th>Acción (Actualizar Estado)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pedidos as $pedido)
                <tr>
                    <td>{{ $pedido->id_pedido }}</td>
                    <td>{{ $pedido->id_cliente }}</td>
                    <td>{{ $pedido->fecha }}</td>
                    <td>${{ $pedido->total }}</td>
                    <td>{{ $pedido->tipo_entrega }}</td>
                    <td>
                        <span class="badge 
                            @if($pedido->estado == 'Creado' || $pedido->estado == 'Pagado') badge-creado 
                            @elseif($pedido->estado == 'En Preparación') badge-preparacion 
                            @elseif($pedido->estado == 'En Camino') badge-camino 
                            @else badge-entregado @endif">
                            {{ $pedido->estado }}
                        </span>
                    </td>
                    <td>
                        <form action="#" method="POST" style="display:flex; gap: 5px;">
                            @csrf
                            @method('PUT')
                            <select name="estado">
                                <option value="Creado" {{ $pedido->estado == 'Creado' ? 'selected' : '' }}>Creado</option>
                                <option value="En Preparación" {{ $pedido->estado == 'En Preparación' ? 'selected' : '' }}>En Preparación</option>
                                <option value="En Camino" {{ $pedido->estado == 'En Camino' ? 'selected' : '' }}>En Camino</option>
                                <option value="Entregado" {{ $pedido->estado == 'Entregado' ? 'selected' : '' }}>Entregado</option>
                            </select>
                            <button type="submit" class="btn-guardar">OK</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;">No hay pedidos registrados en el sistema.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
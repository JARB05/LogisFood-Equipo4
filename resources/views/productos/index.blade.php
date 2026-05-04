@extends('layouts.app')
@section('title', 'Productos')

@section('content')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .page-title  { font-size: 24px; font-weight: 700; color: #1e3a8a; }
    .btn-new { padding: 10px 20px; background: #1d4ed8; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; cursor: pointer; }
    .btn-new:hover { background: #1e40af; }
    table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(37,99,235,0.08); }
    thead { background: #1d4ed8; }
    thead th { padding: 14px 16px; text-align: left; color: #fff; font-size: 13px; font-weight: 600; }
    tbody td { padding: 14px 16px; font-size: 14px; color: #1e293b; border-bottom: 1px solid #e0e7ff; vertical-align: middle; }
    tbody tr:last-child td { border-bottom: none; }
    .prod-img { width: 64px; height: 64px; object-fit: cover; border-radius: 8px; }
    .no-img { width: 64px; height: 64px; background: #e0e7ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 11px; color: #6366f1; }
    .stock-badge { font-size: 12px; font-weight: 600; padding: 3px 9px; border-radius: 20px; display: inline-block; }
    .stock-ok       { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .stock-low      { background: #fef9c3; color: #854d0e; border: 1px solid #fde68a; }
    .stock-critical { background: #fef2f2; color: #b91c1c;  border: 1px solid #fecaca; }
    .acciones { display: flex; gap: 8px; flex-wrap: wrap; }
    .btn-edit { padding: 7px 14px; background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; border-radius: 6px; font-size: 13px; text-decoration: none; }
    .btn-edit:hover { background: #dbeafe; }
    .btn-del  { padding: 7px 14px; background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; border-radius: 6px; font-size: 13px; cursor: pointer; }
    .btn-del:hover { background: #fee2e2; }
    .empty { text-align: center; color: #64748b; padding: 40px; }
</style>

<div class="page-header">
    <h1 class="page-title">Productos</h1>
    <a href="{{ route('productos.create') }}" class="btn-new">Nuevo producto</a>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Categoría</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($productos as $producto)
        <tr>
            <td>{{ $producto->id_producto }}</td>
            <td>
                @if($producto->imagen_url)
                    <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" class="prod-img">
                @else
                    <div class="no-img">Sin img</div>
                @endif
            </td>
            <td>{{ $producto->nombre }}</td>
            <td>${{ number_format($producto->precio, 2) }}</td>
            <td>
                @if($producto->stock >= 10)
                    <span class="stock-badge stock-ok">{{ $producto->stock }}</span>
                @elseif($producto->stock >= 4)
                    <span class="stock-badge stock-low">{{ $producto->stock }}</span>
                @else
                    <span class="stock-badge stock-critical">{{ $producto->stock }}</span>
                @endif
            </td>
            <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
            <td>
                <div class="acciones">
                    <a href="{{ route('productos.edit', $producto->id_producto) }}" class="btn-edit">Editar</a>
                    <form action="{{ route('productos.destroy', $producto->id_producto) }}" method="POST" onsubmit="return confirm('¿Eliminar este producto?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-del">Eliminar</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" class="empty">No hay productos registrados.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection

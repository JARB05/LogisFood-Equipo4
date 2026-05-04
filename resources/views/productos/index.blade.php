@extends('layouts.app')

@section('title', 'Productos — LogisFood')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Catálogo de Productos</h1>
        <p class="text-sm text-gray-500 mt-1">Gestión del inventario de productos disponibles.</p>
    </div>
    <a href="{{ route('productos.create') }}"
       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nuevo producto
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-blue-50 border-b border-blue-100 text-blue-800 text-xs font-semibold uppercase tracking-wide">
                <th class="px-5 py-3 text-left">ID</th>
                <th class="px-5 py-3 text-left">Imagen</th>
                <th class="px-5 py-3 text-left">Nombre</th>
                <th class="px-5 py-3 text-left">Precio</th>
                <th class="px-5 py-3 text-left">Categoría</th>
                {{-- CAMPO STOCK: requerido por instrucciones para mostrar inventario --}}
                <th class="px-5 py-3 text-left">Stock</th>
                <th class="px-5 py-3 text-left">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($productos as $producto)
            <tr class="hover:bg-blue-50/40 transition">
                <td class="px-5 py-3 text-gray-500 font-mono text-xs">{{ $producto->id_producto }}</td>
                <td class="px-5 py-3">
                    @if ($producto->imagen_url)
                        <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}"
                             class="w-14 h-14 object-cover rounded-xl border border-gray-200 shadow-sm">
                    @else
                        <div class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 text-xs">Sin imagen</div>
                    @endif
                </td>
                <td class="px-5 py-3 font-semibold text-gray-800">{{ $producto->nombre }}</td>
                <td class="px-5 py-3 text-gray-700">${{ number_format($producto->precio, 2) }}</td>
                <td class="px-5 py-3 text-gray-600">{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                {{-- Indicador visual de stock --}}
                <td class="px-5 py-3">
                    @php $stock = $producto->stock ?? 0; @endphp
                    @if($stock > 10)
                        <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>
                            {{ $stock }} uds.
                        </span>
                    @elseif($stock > 0)
                        <span class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 inline-block"></span>
                            {{ $stock }} uds.
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block"></span>
                            Agotado
                        </span>
                    @endif
                </td>
                <td class="px-5 py-3">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('productos.edit', $producto->id_producto) }}"
                           class="inline-flex items-center gap-1 bg-blue-100 hover:bg-blue-200 text-blue-700 text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Editar
                        </a>
                        <form action="{{ route('productos.destroy', $producto->id_producto) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar este producto?');">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center gap-1 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Eliminar
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-5 py-10 text-center text-gray-400">No hay productos registrados.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

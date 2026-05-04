@extends('layouts.app')

@section('title', 'Categorías — LogisFood')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Categorías</h1>
        <p class="text-sm text-gray-500 mt-1">Administra las categorías del catálogo de productos.</p>
    </div>
    <a href="{{ route('categorias.create') }}"
       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nueva categoría
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-blue-50 border-b border-blue-100 text-blue-800 text-xs font-semibold uppercase tracking-wide">
                <th class="px-5 py-3 text-left">ID</th>
                <th class="px-5 py-3 text-left">Nombre</th>
                <th class="px-5 py-3 text-left">Productos</th>
                <th class="px-5 py-3 text-left">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($categorias as $categoria)
            <tr class="hover:bg-blue-50/40 transition">
                <td class="px-5 py-3 text-gray-500 font-mono text-xs">{{ $categoria->id_categoria }}</td>
                <td class="px-5 py-3 font-semibold text-gray-800">{{ $categoria->nombre }}</td>
                <td class="px-5 py-3">
                    <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                        {{ $categoria->productos_count ?? $categoria->productos->count() ?? 0 }} productos
                    </span>
                </td>
                <td class="px-5 py-3">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('categorias.edit', $categoria->id_categoria) }}"
                           class="inline-flex items-center gap-1 bg-blue-100 hover:bg-blue-200 text-blue-700 text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Editar
                        </a>
                        <form action="{{ route('categorias.destroy', $categoria->id_categoria) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar esta categoría? Los productos asociados quedarán sin categoría.');">
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
                <td colspan="4" class="px-5 py-10 text-center text-gray-400">No hay categorías registradas.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

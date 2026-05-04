@extends('layouts.app')

@section('title', 'Editar Producto — LogisFood')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('productos.index') }}" class="text-blue-600 hover:text-blue-800 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Editar Producto</h1>
            <p class="text-sm text-gray-500">Modifica los datos del producto <span class="font-semibold text-blue-700">{{ $producto->nombre }}</span>.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
        @if ($errors->any())
            <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 mb-6 text-sm">
                <svg class="w-5 h-5 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('productos.update', $producto->id_producto) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                {{-- ID (solo lectura) --}}
                <div>
                    <label for="id_producto" class="block text-sm font-semibold text-gray-700 mb-1">ID del producto</label>
                    <input type="text" name="id_producto" id="id_producto"
                           value="{{ old('id_producto', $producto->id_producto) }}" required readonly
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                    <p class="text-xs text-gray-400 mt-1">El ID no se puede modificar.</p>
                </div>

                {{-- Nombre --}}
                <div>
                    <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-1">Nombre</label>
                    <input type="text" name="nombre" id="nombre"
                           value="{{ old('nombre', $producto->nombre) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>

                {{-- Precio --}}
                <div>
                    <label for="precio" class="block text-sm font-semibold text-gray-700 mb-1">Precio ($)</label>
                    <input type="number" step="0.01" min="0" name="precio" id="precio"
                           value="{{ old('precio', $producto->precio) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>

                {{--
                    CAMPO STOCK — CRÍTICO:
                    El backend bloqueará el guardado si este campo no se envía.
                    Nombre exacto requerido: "stock"
                --}}
                <div>
                    <label for="stock" class="block text-sm font-semibold text-gray-700 mb-1">
                        Stock
                        <span class="ml-1 text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full font-normal">Requerido por backend</span>
                    </label>
                    <input type="number" min="0" name="stock" id="stock"
                           value="{{ old('stock', $producto->stock ?? 0) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <p class="text-xs text-gray-400 mt-1">Unidades disponibles en inventario.</p>
                </div>
            </div>

            {{-- Categoría --}}
            <div>
                <label for="id_categoria" class="block text-sm font-semibold text-gray-700 mb-1">Categoría</label>
                <select name="id_categoria" id="id_categoria" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition bg-white">
                    <option value="">Seleccione una categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id_categoria }}"
                                {{ old('id_categoria', $producto->id_categoria) == $categoria->id_categoria ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- URL Imagen --}}
            <div>
                <label for="imagen_url" class="block text-sm font-semibold text-gray-700 mb-1">URL de la imagen <span class="font-normal text-gray-400">(opcional)</span></label>
                <input type="url" name="imagen_url" id="imagen_url"
                       value="{{ old('imagen_url', $producto->imagen_url) }}"
                       placeholder="https://ejemplo.com/imagen.jpg"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl transition text-sm shadow-sm">
                    Actualizar producto
                </button>
                <a href="{{ route('productos.index') }}"
                   class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-xl transition text-sm">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Menú — LogisFood')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Menú de Productos</h1>
    <p class="text-sm text-gray-500 mt-1">Elige lo que deseas pedir. El backend solo muestra productos con stock disponible.</p>
</div>

{{-- Grid de tarjetas de productos --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
    @forelse($productos as $producto)
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex flex-col hover:shadow-md hover:border-blue-200 transition">

        {{-- Imagen --}}
        @if($producto->imagen_url)
            <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}"
                 class="w-full h-44 object-cover">
        @else
            <div class="w-full h-44 bg-blue-50 flex items-center justify-center text-blue-300">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif

        <div class="p-4 flex flex-col flex-1">
            {{-- Categoría badge --}}
            <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full self-start mb-2">
                {{ $producto->categoria->nombre ?? 'General' }}
            </span>

            <h3 class="font-bold text-gray-900 text-sm leading-tight mb-1">{{ $producto->nombre }}</h3>

            <div class="flex items-center justify-between mt-auto pt-3">
                <span class="text-lg font-bold text-blue-700">${{ number_format($producto->precio, 2) }}</span>

                {{--
                    INDICADOR VISUAL DE STOCK:
                    El backend oculta los productos con stock=0, pero mostramos
                    cuántas unidades quedan para que el cliente no pida de más.
                --}}
                @php $stock = $producto->stock ?? 0; @endphp
                @if($stock > 10)
                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-green-700 bg-green-100 px-2.5 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                        {{ $stock }} disponibles
                    </span>
                @elseif($stock > 0)
                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-yellow-700 bg-yellow-100 px-2.5 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                        Últimas {{ $stock }}
                    </span>
                @endif
            </div>

            {{-- Botón agregar al carrito --}}
            <form action="{{ route('carrito.agregar', $producto->id_producto) }}" method="POST" class="mt-3">
                @csrf
                <div class="flex gap-2 items-center">
                    <input type="number" name="cantidad" value="1" min="1" max="{{ $producto->stock ?? 1 }}"
                           class="w-16 px-2 py-1.5 border border-gray-300 rounded-lg text-sm text-center focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-2 rounded-xl transition">
                        Agregar al carrito
                    </button>
                </div>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-20 text-gray-400">
        <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
        </svg>
        No hay productos disponibles en este momento.
    </div>
    @endforelse
</div>
@endsection

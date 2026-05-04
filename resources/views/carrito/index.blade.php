@extends('layouts.app')

@section('title', 'Mi Carrito — LogisFood')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Mi Carrito</h1>
    <p class="text-sm text-gray-500 mt-1">Revisa tu pedido antes de confirmar.</p>
</div>

{{--
    ALERTAS DE ERROR DE SESIÓN — CRÍTICO:
    Si el cliente intenta agregar más productos de los que hay en stock,
    el controlador cancela la acción y redirige aquí con session('error').
    Este bloque (y el del layout app.blade.php) lo capturan y lo muestran.
--}}
@if(session('error'))
    <div class="flex items-start gap-3 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-xl p-5 mb-6">
        <svg class="w-6 h-6 mt-0.5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
        <div>
            <p class="font-bold text-sm">No fue posible agregar el producto</p>
            <p class="text-sm mt-0.5">{{ session('error') }}</p>
        </div>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Lista de productos en el carrito --}}
    <div class="lg:col-span-2 space-y-3">
        @forelse($detalles ?? [] as $detalle)
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 flex items-center gap-4">
            @if($detalle->producto->imagen_url ?? false)
                <img src="{{ $detalle->producto->imagen_url }}" alt="{{ $detalle->producto->nombre }}"
                     class="w-16 h-16 rounded-xl object-cover border border-gray-200 shrink-0">
            @else
                <div class="w-16 h-16 rounded-xl bg-blue-50 flex items-center justify-center text-blue-300 shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/>
                    </svg>
                </div>
            @endif

            <div class="flex-1">
                <p class="font-semibold text-gray-800 text-sm">{{ $detalle->producto->nombre ?? 'Producto' }}</p>
                <p class="text-xs text-gray-500">{{ $detalle->producto->categoria->nombre ?? '' }}</p>
                <p class="text-blue-600 font-bold text-sm mt-1">${{ number_format($detalle->precio_unitario ?? 0, 2) }} c/u</p>
            </div>

            <div class="flex items-center gap-2">
                <span class="bg-blue-50 text-blue-700 text-sm font-semibold px-3 py-1 rounded-lg">
                    x{{ $detalle->cantidad }}
                </span>
                {{-- Eliminar del carrito --}}
                <form action="{{ route('carrito.quitar', $detalle->id_detalle_carrito ?? 0) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-gray-400 hover:text-red-500 transition p-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-12 text-center text-gray-400">
            <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <p class="font-semibold text-sm">Tu carrito está vacío</p>
            <a href="{{ route('clientes.menu') }}" class="inline-block mt-3 text-xs text-blue-600 hover:underline">Ver menú de productos</a>
        </div>
        @endforelse
    </div>

    {{-- Panel de resumen y confirmación --}}
    <div class="space-y-4">
        {{-- Resumen de totales --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
            <h2 class="font-bold text-gray-800 mb-4">Resumen del pedido</h2>
            <div class="space-y-2 text-sm text-gray-600">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span>${{ number_format($subtotal ?? 0, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Envío</span>
                    <span id="costo-envio">$0.00</span>
                </div>
                <div class="border-t border-gray-100 pt-2 mt-2 flex justify-between font-bold text-gray-900 text-base">
                    <span>Total</span>
                    <span id="total-final">${{ number_format($subtotal ?? 0, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- Tipo de entrega --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
            <h2 class="font-bold text-gray-800 mb-3">Tipo de entrega</h2>
            <div class="space-y-2">
                <label class="flex items-start gap-3 cursor-pointer group">
                    <input type="radio" name="tipo_entrega" value="local" id="entrega-local"
                           class="mt-0.5 accent-blue-600" checked
                           onchange="actualizarEntrega(this)">
                    <div>
                        <p class="font-semibold text-sm text-gray-800">Recoger en tienda</p>
                        <p class="text-xs text-gray-500">Sin costo adicional</p>
                    </div>
                </label>
                <label class="flex items-start gap-3 cursor-pointer group">
                    <input type="radio" name="tipo_entrega" value="domicilio" id="entrega-domicilio"
                           class="mt-0.5 accent-blue-600"
                           onchange="actualizarEntrega(this)">
                    <div>
                        <p class="font-semibold text-sm text-gray-800">Entrega a domicilio</p>
                        <p class="text-xs text-gray-500">Costo adicional de $35.00</p>
                    </div>
                </label>
            </div>
        </div>

        {{-- Confirmar pedido --}}
        <form action="{{ route('pedidos.store') }}" method="POST">
            @csrf
            <input type="hidden" name="tipo_entrega" id="tipo_entrega_hidden" value="local">
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition text-sm shadow-sm">
                Confirmar pedido
            </button>
        </form>

        <a href="{{ route('clientes.menu') }}"
           class="block w-full text-center text-sm text-blue-600 hover:underline">
            ← Seguir comprando
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
const COSTO_DOMICILIO = 35;
const subtotal = {{ $subtotal ?? 0 }};

function actualizarEntrega(radio) {
    const domicilio = radio.value === 'domicilio';
    const costo = domicilio ? COSTO_DOMICILIO : 0;
    document.getElementById('costo-envio').textContent = '$' + costo.toFixed(2);
    document.getElementById('total-final').textContent = '$' + (subtotal + costo).toFixed(2);
    document.getElementById('tipo_entrega_hidden').value = radio.value;
}
</script>
@endpush

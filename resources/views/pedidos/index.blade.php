@extends('layouts.app')

@section('title', 'Pedidos — LogisFood')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Órdenes y Pedidos</h1>
    <p class="text-sm text-gray-500 mt-1">
        {{-- Mensaje dinámico según el rol del usuario en sesión --}}
        @if(auth()->user()->rol === 'Cliente')
            Aquí puedes ver el estado de tus pedidos.
        @elseif(auth()->user()->rol === 'Empleado')
            Marca los pedidos como pagados o en preparación cuando los recibas.
        @elseif(auth()->user()->rol === 'Repartidor')
            Gestiona los pedidos que están listos para entregar.
        @else
            Vista general de todas las órdenes del sistema.
        @endif
    </p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-x-auto">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-blue-50 border-b border-blue-100 text-blue-800 text-xs font-semibold uppercase tracking-wide">
                <th class="px-5 py-3 text-left">ID Pedido</th>
                <th class="px-5 py-3 text-left">Cliente</th>
                <th class="px-5 py-3 text-left">Fecha</th>
                <th class="px-5 py-3 text-left">Total</th>
                <th class="px-5 py-3 text-left">Entrega</th>
                <th class="px-5 py-3 text-left">Estado</th>
                {{-- La columna de acción solo aparece si el rol tiene permisos --}}
                @if(auth()->user()->rol !== 'Cliente')
                <th class="px-5 py-3 text-left">Acción</th>
                @endif
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($pedidos as $pedido)
            <tr class="hover:bg-blue-50/30 transition">
                <td class="px-5 py-3 font-mono text-xs text-gray-500">#{{ $pedido->id_pedido }}</td>
                <td class="px-5 py-3 text-gray-700">{{ $pedido->id_cliente }}</td>
                <td class="px-5 py-3 text-gray-600 text-xs">{{ $pedido->fecha }}</td>
                <td class="px-5 py-3 font-semibold text-gray-800">${{ number_format($pedido->total, 2) }}</td>
                <td class="px-5 py-3">
                    @if($pedido->tipo_entrega === 'domicilio')
                        <span class="inline-flex items-center gap-1 text-xs bg-purple-100 text-purple-700 font-semibold px-2.5 py-1 rounded-full">
                            🏠 Domicilio
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 text-xs bg-gray-100 text-gray-600 font-semibold px-2.5 py-1 rounded-full">
                            🏪 Local
                        </span>
                    @endif
                </td>

                {{-- Badges de estado con color --}}
                <td class="px-5 py-3">
                    @php
                        $badgeClass = match($pedido->estado) {
                            'Creado'         => 'bg-gray-100 text-gray-600',
                            'Pagado'         => 'bg-blue-100 text-blue-700',
                            'En Preparación' => 'bg-yellow-100 text-yellow-700',
                            'En Camino'      => 'bg-orange-100 text-orange-700',
                            'Entregado'      => 'bg-green-100 text-green-700',
                            default          => 'bg-gray-100 text-gray-600',
                        };
                    @endphp
                    <span class="inline-block text-xs font-semibold px-2.5 py-1 rounded-full {{ $badgeClass }}">
                        {{ $pedido->estado }}
                    </span>
                </td>

                {{--
                    BOTONES DINÁMICOS POR ROL — CRÍTICO:
                    Cada rol solo ve el botón correspondiente a su acción permitida.
                    El backend tiene los candados, pero el frontend ayuda a guiar al usuario.

                    - Cliente     → sin botones de acción (solo lectura)
                    - Empleado    → puede marcar como Pagado o En Preparación
                    - Repartidor  → puede marcar como En Camino o Entregado
                    - Administrador → ve todas las opciones (selector completo)
                --}}
                @if(auth()->user()->rol !== 'Cliente')
                <td class="px-5 py-3">
                    <form action="{{ route('pedidos.update', $pedido->id_pedido) }}" method="POST"
                          class="flex items-center gap-2">
                        @csrf @method('PUT')

                        @if(auth()->user()->rol === 'Empleado')
                            {{-- Empleado: avanza de Creado → Pagado → En Preparación --}}
                            @if($pedido->estado === 'Creado')
                                <button type="submit" name="estado" value="Pagado"
                                        class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                    ✅ Marcar Pagado
                                </button>
                            @elseif($pedido->estado === 'Pagado')
                                <button type="submit" name="estado" value="En Preparación"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                    👨‍🍳 En Preparación
                                </button>
                            @else
                                <span class="text-xs text-gray-400 italic">Sin acción disponible</span>
                            @endif

                        @elseif(auth()->user()->rol === 'Repartidor')
                            {{-- Repartidor: avanza de En Preparación → En Camino → Entregado --}}
                            @if($pedido->estado === 'En Preparación')
                                <button type="submit" name="estado" value="En Camino"
                                        class="bg-orange-500 hover:bg-orange-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                    🚚 En Camino
                                </button>
                            @elseif($pedido->estado === 'En Camino')
                                <button type="submit" name="estado" value="Entregado"
                                        class="bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                    📦 Entregado
                                </button>
                            @else
                                <span class="text-xs text-gray-400 italic">Sin acción disponible</span>
                            @endif

                        @elseif(auth()->user()->rol === 'Administrador')
                            {{-- Administrador: selector completo de estados --}}
                            <select name="estado"
                                    class="px-3 py-1.5 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                                @foreach(['Creado','Pagado','En Preparación','En Camino','Entregado'] as $estado)
                                    <option value="{{ $estado }}" {{ $pedido->estado === $estado ? 'selected' : '' }}>
                                        {{ $estado }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                Guardar
                            </button>
                        @endif
                    </form>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-5 py-10 text-center text-gray-400">No hay pedidos registrados en el sistema.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Pedidos - LogisFood')

@section('content')
<style>
    .page-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 32px; flex-wrap: wrap; gap: 16px; }
    .page-title { font-size: 26px; font-weight: 800; color: #111827; letter-spacing: -0.4px; margin: 0 0 4px; }
    .page-subtitle { font-size: 13px; color: #9CA3AF; font-weight: 500; margin: 0; }

    .btn-new-order {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 11px 20px; background: linear-gradient(135deg, #FF6700, #FF8030);
        color: #fff; border: none; border-radius: 12px;
        font-size: 14px; font-weight: 700; text-decoration: none;
        font-family: 'Outfit', sans-serif;
        box-shadow: 0 4px 12px rgba(255,103,0,0.28);
        transition: transform 0.15s, box-shadow 0.15s;
        white-space: nowrap;
    }
    .btn-new-order:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(255,103,0,0.38); }

    .lf-table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 16px rgba(0,0,0,0.06); }
    .lf-table thead { background: #111827; }
    .lf-table thead th { padding: 14px 20px; text-align: left; color: #fff; font-size: 12px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; }
    .lf-table tbody td { padding: 16px 20px; font-size: 14px; color: #374151; border-bottom: 1px solid #F3EDE4; font-weight: 500; vertical-align: middle; }
    .lf-table tbody tr:last-child td { border-bottom: none; }

    .order-row { cursor: pointer; transition: background 0.1s; }
    .order-row:hover { background: #FAFAF8; }
    .order-row.open { background: #FFF7F0; }

    .order-id { font-size: 12px; font-weight: 800; color: #9CA3AF; font-family: monospace; letter-spacing: 0.5px; }
    .client-name { font-weight: 700; color: #111827; }
    .order-date { font-size: 13px; color: #6B7280; }
    .order-total { font-weight: 800; color: #111827; font-size: 15px; }

    .chevron { transition: transform 0.2s; color: #C4BAB0; flex-shrink: 0; }
    .open .chevron { transform: rotate(180deg); color: #FF6700; }

    .order-id-wrap { display: flex; align-items: center; gap: 8px; }

    .entrega-pill {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700;
        background: #F3EDE4; color: #6B7280; border: 1.5px solid #E5E0D8;
    }

    .badge { display: inline-flex; align-items: center; gap: 5px; padding: 5px 11px; border-radius: 20px; font-size: 12px; font-weight: 700; }
    .badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; flex-shrink: 0; }
    .badge-Creado      { background: #F9FAFB; color: #6B7280; border: 1.5px solid #E5E7EB; }
    .badge-Pagado      { background: #EFF6FF; color: #2563EB; border: 1.5px solid #BFDBFE; }
    .badge-Preparacion { background: #FFFBEB; color: #B45309; border: 1.5px solid #FDE68A; }
    .badge-Camino      { background: #FFF7ED; color: #C2410C; border: 1.5px solid #FED7AA; }
    .badge-Entregado   { background: #F0FDF4; color: #15803D; border: 1.5px solid #BBF7D0; }

    .btn-accion {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 14px; border: none; border-radius: 10px;
        font-size: 12px; font-weight: 700; cursor: pointer;
        font-family: 'Outfit', sans-serif;
        background: linear-gradient(135deg, #FF6700, #FF8030);
        color: #fff; box-shadow: 0 3px 10px rgba(255,103,0,0.22);
        transition: transform 0.15s, box-shadow 0.15s; white-space: nowrap;
    }
    .btn-accion:hover { transform: translateY(-1px); box-shadow: 0 5px 14px rgba(255,103,0,0.35); }
    .btn-accion.repartidor { background: linear-gradient(135deg, #0f766e, #0d9488); box-shadow: 0 3px 10px rgba(15,118,110,0.22); }
    .btn-accion.repartidor:hover { box-shadow: 0 5px 14px rgba(15,118,110,0.35); }

    .rep-form { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
    .rep-select {
        padding: 8px 12px; border: 1.5px solid #E5E0D8; border-radius: 10px;
        font-size: 12px; font-weight: 600; color: #374151;
        background: #FAFAF8; font-family: 'Outfit', sans-serif; outline: none;
        transition: border-color 0.2s; cursor: pointer;
    }
    .rep-select:focus { border-color: #FF6700; }

    .no-action { font-size: 12px; color: #D1C4B5; font-weight: 600; }
    .empty td { text-align: center; color: #9CA3AF; padding: 60px; font-size: 14px; font-weight: 500; }

    .progress-mini { display: flex; align-items: center; gap: 3px; }
    .progress-dot { width: 8px; height: 8px; border-radius: 50%; background: #E5E0D8; flex-shrink: 0; }
    .progress-dot.done { background: #15803D; }
    .progress-dot.active { background: #FF6700; }
    .progress-line { width: 12px; height: 2px; background: #E5E0D8; flex-shrink: 0; }
    .progress-line.done { background: #BBF7D0; }

    /* Fila de detalles expandible */
    .detail-row { display: none; }
    .detail-row.open { display: table-row; }
    .detail-row td { padding: 0 !important; border-bottom: 2px solid #FFD4B3 !important; background: #FFFAF5; }

    .detail-inner { padding: 16px 24px 20px; }
    .detail-title { font-size: 11px; font-weight: 800; color: #FF6700; text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }
    .detail-title::after { content: ''; flex: 1; height: 1.5px; background: #FFD4B3; border-radius: 2px; }

    .detail-items { display: flex; flex-direction: column; gap: 8px; }
    .detail-item { display: flex; align-items: center; justify-content: space-between; background: #fff; border: 1.5px solid #F3EDE4; border-radius: 10px; padding: 10px 14px; }
    .detail-item-left { display: flex; align-items: center; gap: 10px; }
    .detail-qty { width: 26px; height: 26px; background: #FFF7F0; border: 1.5px solid #FFD4B3; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 800; color: #FF6700; flex-shrink: 0; }
    .detail-name { font-size: 13px; font-weight: 700; color: #111827; }
    .detail-unit { font-size: 12px; color: #9CA3AF; font-weight: 500; }
    .detail-subtotal { font-size: 14px; font-weight: 800; color: #FF6700; }
    .detail-empty { font-size: 13px; color: #9CA3AF; font-weight: 500; font-style: italic; }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">
            @if(auth()->user()->rol === 'Cliente') Mis Pedidos
            @elseif(auth()->user()->rol === 'Empleado') Gestión de Pedidos
            @elseif(auth()->user()->rol === 'Repartidor') Pedidos para Entrega
            @else Todos los Pedidos
            @endif
        </h1>
        <p class="page-subtitle">
            @if(auth()->user()->rol === 'Cliente') Haz click en un pedido para ver sus productos
            @elseif(auth()->user()->rol === 'Empleado') Administra el flujo de órdenes activas
            @elseif(auth()->user()->rol === 'Repartidor') Pedidos asignados listos para entregar
            @else Vista completa de todas las órdenes
            @endif
        </p>
    </div>
    @if(auth()->user()->rol === 'Cliente')
        <a href="{{ route('productos.menu') }}" class="btn-new-order">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Nuevo pedido
        </a>
    @endif
</div>

<table class="lf-table">
    <thead>
        <tr>
            <th>Pedido</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Entrega</th>
            <th>Estado</th>
            <th>Progreso</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pedidos as $pedido)
        @php
            $rol       = auth()->user()->rol;
            $estado    = $pedido->estado;
            $estados   = ['Creado', 'Pagado', 'En Preparación', 'En Camino', 'Entregado'];
            $estadoIdx = array_search($estado, $estados);

            $badgeClass = match($estado) {
                'Creado'         => 'badge-Creado',
                'Pagado'         => 'badge-Pagado',
                'En Preparación' => 'badge-Preparacion',
                'En Camino'      => 'badge-Camino',
                'Entregado'      => 'badge-Entregado',
                default          => 'badge-Creado',
            };

            $accion = null;
            if ($rol === 'Cliente' && $estado === 'Creado') {
                $accion = ['label' => 'Pagar ahora', 'route' => route('pedidos.pagar', $pedido->id_pedido), 'class' => '', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>'];
            } elseif (in_array($rol, ['Empleado', 'Administrador']) && $estado === 'Pagado') {
                $accion = ['label' => 'Iniciar prep.', 'route' => route('pedidos.preparar', $pedido->id_pedido), 'class' => '', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>'];
            } elseif (in_array($rol, ['Empleado', 'Administrador']) && $estado === 'En Preparación') {
                $accion = ['label' => 'Enviar', 'route' => route('pedidos.enviar', $pedido->id_pedido), 'class' => '', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l14 9-14 9V3z"/>'];
            } elseif ($rol === 'Repartidor' && $estado === 'En Camino') {
                $accion = ['label' => 'Entregado', 'route' => route('pedidos.entregar', $pedido->id_pedido), 'class' => 'repartidor', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>'];
            }
        @endphp

        {{-- Fila principal del pedido --}}
        <tr class="order-row" onclick="toggleDetalle('detalle-{{ $pedido->id_pedido }}', this)">
            <td>
                <div class="order-id-wrap">
                    <svg class="chevron" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                    <span class="order-id">#{{ str_pad($pedido->id_pedido, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
            </td>
            <td><span class="client-name">{{ $pedido->cliente->nombre ?? $pedido->id_cliente }}</span></td>
            <td><span class="order-date">{{ \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y') }}</span></td>
            <td><span class="order-total">${{ number_format($pedido->total, 2) }}</span></td>
            <td>
                <span class="entrega-pill">
                    {{ $pedido->tipo_entrega === 'Domicilio' ? '🛵' : '🏠' }}
                    {{ $pedido->tipo_entrega }}
                </span>
            </td>
            <td><span class="badge {{ $badgeClass }}">{{ $estado }}</span></td>
            <td>
                <div class="progress-mini">
                    @foreach($estados as $i => $e)
                        <div class="progress-dot {{ $i < $estadoIdx ? 'done' : ($i === $estadoIdx ? 'active' : '') }}"></div>
                        @if(!$loop->last)
                            <div class="progress-line {{ $i < $estadoIdx ? 'done' : '' }}"></div>
                        @endif
                    @endforeach
                </div>
            </td>
            <td onclick="event.stopPropagation()">
                @if($accion)
                    @if($estado === 'En Preparación' && in_array($rol, ['Empleado', 'Administrador']))
                        <form action="{{ $accion['route'] }}" method="POST" class="rep-form">
                            @csrf
                            <select name="id_repartidor" required class="rep-select">
                                <option value="">Repartidor...</option>
                                @foreach(\App\Models\Usuario::where('rol','Repartidor')->get() as $rep)
                                    <option value="{{ $rep->id_usuario }}">{{ $rep->nombre }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn-accion">
                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $accion['icon'] !!}</svg>
                                {{ $accion['label'] }}
                            </button>
                        </form>
                    @else
                        <form action="{{ $accion['route'] }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-accion {{ $accion['class'] }}">
                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $accion['icon'] !!}</svg>
                                {{ $accion['label'] }}
                            </button>
                        </form>
                    @endif
                @elseif($estado === 'Entregado')
                    <span style="font-size:13px;">✓ Completado</span>
                @else
                    <span class="no-action">Esperando acción</span>
                @endif
            </td>
        </tr>

        {{-- Fila de detalles expandible --}}
        <tr class="detail-row" id="detalle-{{ $pedido->id_pedido }}">
            <td colspan="8">
                <div class="detail-inner">
                    <div class="detail-title">Productos del pedido</div>
                    <div class="detail-items">
                        @forelse($pedido->detalles as $detalle)
                            <div class="detail-item">
                                <div class="detail-item-left">
                                    <div class="detail-qty">{{ $detalle->cantidad }}</div>
                                    <div>
                                        <div class="detail-name">{{ $detalle->producto->nombre ?? 'Producto eliminado' }}</div>
                                        <div class="detail-unit">${{ number_format($detalle->precio_unitario, 2) }} c/u</div>
                                    </div>
                                </div>
                                <div class="detail-subtotal">${{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}</div>
                            </div>
                        @empty
                            <p class="detail-empty">Sin detalles registrados para este pedido.</p>
                        @endforelse
                    </div>
                </div>
            </td>
        </tr>

        @empty
        <tr class="empty">
            <td colspan="8">
                @if(auth()->user()->rol === 'Cliente')
                    No tienes pedidos aún. <a href="{{ route('productos.menu') }}" style="color:#FF6700;font-weight:700;text-decoration:none;">Ver menú →</a>
                @else
                    No hay pedidos registrados.
                @endif
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

@push('scripts')
<script>
function toggleDetalle(id, row) {
    const detalle = document.getElementById(id);
    const isOpen = detalle.classList.contains('open');
    document.querySelectorAll('.detail-row.open').forEach(r => r.classList.remove('open'));
    document.querySelectorAll('.order-row.open').forEach(r => r.classList.remove('open'));
    if (!isOpen) {
        detalle.classList.add('open');
        row.classList.add('open');
    }
}
</script>
@endpush
@endsection
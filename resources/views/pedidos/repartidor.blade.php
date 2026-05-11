@extends('layouts.app')
@section('title', 'Mis Entregas - LogisFood')

@section('content')
<style>
    .page-header { margin-bottom: 28px; }
    .page-title { font-size: 26px; font-weight: 800; color: #111827; letter-spacing: -0.4px; margin: 0 0 4px; }
    .page-subtitle { font-size: 13px; color: #9CA3AF; font-weight: 500; margin: 0; }

    .stats-row { display: flex; gap: 12px; margin-bottom: 28px; flex-wrap: wrap; }
    .stat-pill { display: inline-flex; align-items: center; gap: 8px; background: #fff; border: 1.5px solid #F3EDE4; border-radius: 50px; padding: 8px 16px; font-size: 13px; font-weight: 700; color: #374151; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
    .stat-pill .dot { width: 8px; height: 8px; border-radius: 50%; background: #FF6700; flex-shrink: 0; }
    .stat-pill .dot.green { background: #15803D; }

    .entregas-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px; }

    .entrega-card { background: #fff; border-radius: 20px; border: 1.5px solid #F3EDE4; box-shadow: 0 2px 14px rgba(0,0,0,0.06); overflow: hidden; display: flex; flex-direction: column; }

    .card-header { padding: 16px 20px; background: linear-gradient(135deg, #111827, #1f2937); display: flex; align-items: center; justify-content: space-between; }
    .card-order-id { font-size: 13px; font-weight: 800; color: #fff; font-family: monospace; letter-spacing: 0.5px; }
    .card-status { display: inline-flex; align-items: center; gap: 5px; background: #FFF7ED; color: #C2410C; border: 1.5px solid #FED7AA; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
    .card-status::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

    .card-entregado-header { background: linear-gradient(135deg, #14532d, #166534); }
    .card-entregado-status { background: #F0FDF4; color: #15803D; border-color: #BBF7D0; }

    .card-body { padding: 18px 20px; flex: 1; display: flex; flex-direction: column; gap: 14px; }

    .client-block { display: flex; flex-direction: column; gap: 6px; }
    .client-row { display: flex; align-items: center; gap: 10px; }
    .client-avatar { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #FF6700, #FF8C3A); display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 800; color: #fff; flex-shrink: 0; }
    .client-name { font-size: 15px; font-weight: 800; color: #111827; }
    .client-email { font-size: 12px; color: #9CA3AF; font-weight: 500; }

    .address-block { display: flex; align-items: flex-start; gap: 8px; background: #F9F6F1; border: 1.5px solid #F3EDE4; border-radius: 12px; padding: 12px 14px; }
    .address-block svg { flex-shrink: 0; margin-top: 1px; color: #FF6700; }
    .address-label { font-size: 10px; font-weight: 700; color: #9CA3AF; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 2px; }
    .address-text { font-size: 13px; font-weight: 600; color: #374151; line-height: 1.4; }

    .products-block { display: flex; flex-direction: column; gap: 6px; }
    .products-label { font-size: 10px; font-weight: 800; color: #9CA3AF; text-transform: uppercase; letter-spacing: 0.6px; display: flex; align-items: center; gap: 8px; }
    .products-label::after { content: ''; flex: 1; height: 1.5px; background: #F3EDE4; border-radius: 2px; }
    .product-line { display: flex; align-items: center; justify-content: space-between; font-size: 13px; padding: 4px 0; }
    .product-line-left { display: flex; align-items: center; gap: 8px; color: #374151; font-weight: 600; }
    .product-qty { width: 22px; height: 22px; background: #FFF7F0; border: 1.5px solid #FFD4B3; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 800; color: #FF6700; flex-shrink: 0; }
    .product-subtotal { font-size: 13px; font-weight: 700; color: #6B7280; }

    .card-footer { padding: 14px 20px; border-top: 1.5px solid #F3EDE4; display: flex; align-items: center; justify-content: space-between; }
    .total-wrap { display: flex; flex-direction: column; }
    .total-label { font-size: 10px; font-weight: 700; color: #9CA3AF; text-transform: uppercase; letter-spacing: 0.4px; }
    .total-value { font-size: 20px; font-weight: 800; color: #FF6700; letter-spacing: -0.5px; }

    .btn-entregar { display: inline-flex; align-items: center; gap: 7px; padding: 11px 20px; background: linear-gradient(135deg, #0f766e, #0d9488); color: #fff; border: none; border-radius: 12px; font-size: 13px; font-weight: 700; cursor: pointer; font-family: 'Outfit', sans-serif; box-shadow: 0 4px 12px rgba(15,118,110,0.28); transition: transform 0.15s, box-shadow 0.15s; white-space: nowrap; }
    .btn-entregar:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(15,118,110,0.38); }

    .entregado-badge { display: inline-flex; align-items: center; gap: 7px; padding: 10px 16px; background: #F0FDF4; color: #15803D; border: 1.5px solid #BBF7D0; border-radius: 12px; font-size: 13px; font-weight: 700; }

    .empty-state { text-align: center; padding: 80px 20px; color: #9CA3AF; background: #fff; border-radius: 20px; border: 1.5px solid #F3EDE4; }
    .empty-state p { font-size: 15px; font-weight: 600; margin: 12px 0 4px; color: #374151; }
    .empty-state span { font-size: 13px; font-weight: 500; }
</style>

<div class="page-header">
    <h1 class="page-title">Mis Entregas</h1>
    <p class="page-subtitle">Pedidos asignados a ti</p>
</div>

@if($pedidos->isNotEmpty())
    @php
        $enCamino   = $pedidos->where('estado', 'En Camino')->count();
        $entregados = $pedidos->where('estado', 'Entregado')->count();
    @endphp
    <div class="stats-row">
        <div class="stat-pill"><span class="dot"></span> {{ $enCamino }} en camino</div>
        <div class="stat-pill"><span class="dot green"></span> {{ $entregados }} entregados</div>
    </div>
@endif

@if($pedidos->isEmpty())
    <div class="empty-state">
        <svg width="52" height="52" fill="none" stroke="#E5E0D8" viewBox="0 0 24 24" style="margin:0 auto"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
        <p>No tienes entregas asignadas</p>
        <span>Cuando un empleado te asigne un pedido aparecerá aquí.</span>
    </div>
@else
    <div class="entregas-grid">
        @foreach($pedidos as $pedido)
        @php $entregado = $pedido->estado === 'Entregado'; @endphp
        <div class="entrega-card">
            <div class="card-header {{ $entregado ? 'card-entregado-header' : '' }}">
                <span class="card-order-id">#{{ str_pad($pedido->id_pedido, 5, '0', STR_PAD_LEFT) }}</span>
                <span class="card-status {{ $entregado ? 'card-entregado-status' : '' }}">
                    {{ $pedido->estado }}
                </span>
            </div>

            <div class="card-body">
                {{-- Cliente --}}
                <div class="client-block">
                    <div class="client-row">
                        <div class="client-avatar">{{ strtoupper(substr($pedido->cliente->nombre ?? 'C', 0, 1)) }}</div>
                        <div>
                            <div class="client-name">{{ $pedido->cliente->nombre ?? 'Cliente' }}</div>
                            <div class="client-email">{{ $pedido->cliente->email ?? '' }}</div>
                        </div>
                    </div>
                </div>

                {{-- Dirección --}}
                <div class="address-block">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <div>
                        <div class="address-label">Dirección de entrega</div>
                        <div class="address-text">{{ $pedido->cliente->direccion ?? 'Sin dirección registrada' }}</div>
                    </div>
                </div>

                {{-- Productos --}}
                <div class="products-block">
                    <span class="products-label">Productos</span>
                    @foreach($pedido->detalles as $detalle)
                        <div class="product-line">
                            <div class="product-line-left">
                                <div class="product-qty">{{ $detalle->cantidad }}</div>
                                {{ $detalle->producto->nombre ?? 'Producto eliminado' }}
                            </div>
                            <span class="product-subtotal">${{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card-footer">
                <div class="total-wrap">
                    <span class="total-label">Total</span>
                    <span class="total-value">${{ number_format($pedido->total, 2) }}</span>
                </div>

                @if(!$entregado)
                    <form action="{{ route('pedidos.entregar', $pedido->id_pedido) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-entregar">
                            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Confirmar entrega
                        </button>
                    </form>
                @else
                    <div class="entregado-badge">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Entregado
                    </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection
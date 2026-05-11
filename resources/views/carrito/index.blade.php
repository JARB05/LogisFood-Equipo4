@extends('layouts.app')
@section('title', 'Mi Carrito - LogisFood')

@section('content')
<style>
    .cart-header { display:flex; align-items:center; gap:12px; margin-bottom:28px; }
    .cart-header h1 { font-size:26px; font-weight:800; color:#111827; letter-spacing:-0.4px; margin:0; }
    .cart-header .count-badge { background:#FF6700; color:#fff; font-size:12px; font-weight:700; padding:3px 10px; border-radius:20px; }

    .cart-layout { display:flex; gap:24px; align-items:flex-start; }
    .cart-table-wrap { flex:1; min-width:0; }
    .cart-sidebar { width:300px; flex-shrink:0; }

    .lf-table { width:100%; border-collapse:collapse; background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 2px 16px rgba(0,0,0,0.06); }
    .lf-table thead { background:#111827; }
    .lf-table thead th { padding:14px 18px; text-align:left; color:#fff; font-size:12px; font-weight:700; letter-spacing:0.5px; text-transform:uppercase; }
    .lf-table tbody td { padding:16px 18px; font-size:14px; color:#374151; border-bottom:1px solid #F3EDE4; font-weight:500; }
    .lf-table tbody tr:last-child td { border-bottom:none; }
    .lf-table tbody tr:hover { background:#FAFAF8; }
    .prod-name { font-weight:700; color:#111827; }
    .prod-price { font-weight:600; color:#6B7280; }
    .prod-qty { display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; background:#F3EDE4; border-radius:8px; font-weight:700; color:#111827; font-size:14px; }
    .prod-subtotal { font-weight:700; color:#FF6700; }
    .btn-remove { display:inline-flex; align-items:center; gap:5px; padding:7px 12px; background:#FFF5F5; color:#DC2626; border:1.5px solid #FECACA; border-radius:8px; font-size:12px; font-weight:600; cursor:pointer; font-family:'Outfit',sans-serif; transition:background 0.15s; }
    .btn-remove:hover { background:#FEE2E2; }
    .empty-cart { text-align:center; padding:60px 20px; }
    .empty-cart p { font-size:15px; color:#9CA3AF; font-weight:500; margin:12px 0 0; }

    .summary-card { background:#fff; border-radius:16px; box-shadow:0 2px 16px rgba(0,0,0,0.06); overflow:hidden; position:sticky; top:80px; }
    .summary-header { background:linear-gradient(135deg,#FF6700,#FF8030); padding:18px 22px; }
    .summary-header h2 { font-size:15px; font-weight:800; color:#fff; margin:0; letter-spacing:0.2px; }
    .summary-body { padding:22px; }
    .summary-row { display:flex; justify-content:space-between; align-items:center; font-size:13px; color:#6B7280; font-weight:500; margin-bottom:10px; }
    .summary-row span:last-child { font-weight:700; color:#111827; }
    .summary-divider { border:none; border-top:1.5px solid #F3EDE4; margin:14px 0; }
    .summary-total { display:flex; justify-content:space-between; align-items:center; }
    .summary-total span:first-child { font-size:14px; font-weight:700; color:#374151; }
    .summary-total span:last-child { font-size:22px; font-weight:800; color:#FF6700; }

    .entrega-label { font-size:12px; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:0.4px; display:block; margin:18px 0 10px; }
    .entrega-opts { display:grid; grid-template-columns:1fr 1fr; gap:8px; }
    .entrega-opt { border:1.5px solid #E5E0D8; border-radius:10px; padding:10px; text-align:center; cursor:pointer; transition:all 0.15s; }
    .entrega-opt input { display:none; }
    .entrega-opt-label { font-size:13px; font-weight:700; color:#6B7280; display:block; margin-top:4px; }
    .entrega-opt:has(input:checked) { border-color:#FF6700; background:#FFF7F0; }
    .entrega-opt:has(input:checked) .entrega-opt-label { color:#FF6700; }
    .entrega-icon { font-size:20px; }

    .btn-checkout { display:flex; width:100%; align-items:center; justify-content:center; gap:8px; margin-top:16px; padding:14px; background:linear-gradient(135deg,#FF6700,#FF8030); color:#fff; border:none; border-radius:12px; font-size:15px; font-weight:700; cursor:pointer; font-family:'Outfit',sans-serif; box-shadow:0 4px 14px rgba(255,103,0,0.30); transition:transform 0.15s, box-shadow 0.15s; }
    .btn-checkout:hover { transform:translateY(-1px); box-shadow:0 6px 18px rgba(255,103,0,0.40); }
    .btn-checkout:disabled { background:#E5E7EB; color:#9CA3AF; box-shadow:none; cursor:not-allowed; transform:none; }

    .alert-error { display:flex; gap:12px; align-items:flex-start; background:#FFF5F5; border:1.5px solid #FECACA; border-left:4px solid #EF4444; padding:14px 18px; border-radius:12px; margin-bottom:24px; font-size:14px; color:#991B1B; font-weight:500; }

    @media (max-width: 768px) {
        .cart-layout { flex-direction:column; }
        .cart-sidebar { width:100%; }
    }
</style>

<div class="cart-header">
    <h1>Mi Carrito</h1>
    @if(!$detalles->isEmpty())
        <span class="count-badge">{{ $detalles->sum('cantidad') }} items</span>
    @endif
</div>

@if($errors->any())
    <div class="alert-error">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="shrink:0;margin-top:1px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <div>
            <strong style="display:block;margin-bottom:2px;">No se pudo completar la acción</strong>
            @foreach($errors->all() as $error) {{ $error }} @endforeach
        </div>
    </div>
@endif

<div class="cart-layout">
    <div class="cart-table-wrap">
        <table class="lf-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cant.</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($detalles as $detalle)
                <tr>
                    <td><span class="prod-name">{{ $detalle->producto->nombre ?? 'Producto eliminado' }}</span></td>
                    <td><span class="prod-price">${{ number_format($detalle->producto->precio ?? 0, 2) }}</span></td>
                    <td><span class="prod-qty">{{ $detalle->cantidad }}</span></td>
                    <td><span class="prod-subtotal">${{ number_format(($detalle->producto->precio ?? 0) * $detalle->cantidad, 2) }}</span></td>
                    <td>
                        <form action="{{ route('carrito.eliminar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_producto" value="{{ $detalle->id_producto }}">
                            <button type="submit" class="btn-remove">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Quitar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-cart">
                            <svg width="48" height="48" fill="none" stroke="#E5E0D8" viewBox="0 0 24 24" style="margin:0 auto"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <p>Tu carrito está vacío</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="cart-sidebar">
        <div class="summary-card">
            <div class="summary-header"><h2>Resumen del pedido</h2></div>
            <div class="summary-body">
                <div class="summary-row">
                    <span>Artículos</span>
                    <span>{{ $detalles->sum('cantidad') }}</span>
                </div>
                <div class="summary-row">
                    <span>Productos distintos</span>
                    <span>{{ $detalles->count() }}</span>
                </div>
                <hr class="summary-divider">
                <div class="summary-total">
                    <span>Total</span>
                    <span>${{ number_format($detalles->sum(fn($d) => ($d->producto->precio ?? 0) * $d->cantidad), 2) }}</span>
                </div>

                <form action="{{ route('carrito.checkout') }}" method="POST">
                    @csrf
                    <span class="entrega-label">Tipo de entrega</span>
                    <div class="entrega-opts">
                        <label class="entrega-opt">
                            <input type="radio" name="tipo_entrega" value="Local" required>
                            <span class="entrega-icon">🏠</span>
                            <span class="entrega-opt-label">Local</span>
                        </label>
                        <label class="entrega-opt">
                            <input type="radio" name="tipo_entrega" value="Domicilio">
                            <span class="entrega-icon">🛵</span>
                            <span class="entrega-opt-label">Domicilio</span>
                        </label>
                    </div>
                    <button type="submit" class="btn-checkout" {{ $detalles->isEmpty() ? 'disabled' : '' }}>
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Realizar pedido
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
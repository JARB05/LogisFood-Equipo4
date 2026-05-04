@extends('layouts.app')
@section('title', 'Mi Carrito')

@section('content')
<style>
    .page-title { font-size: 24px; font-weight: 700; color: #1e3a8a; margin-bottom: 24px; }
    .layout { display: flex; gap: 24px; align-items: flex-start; flex-wrap: wrap; }
    .tabla-wrap { flex: 1; min-width: 0; }
    .sidebar { width: 300px; flex-shrink: 0; }

    /* Tabla */
    table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(37,99,235,0.08); }
    thead { background: #1d4ed8; }
    thead th { padding: 14px 16px; text-align: left; color: #fff; font-size: 13px; font-weight: 600; }
    tbody td { padding: 14px 16px; font-size: 14px; color: #1e293b; border-bottom: 1px solid #e0e7ff; }
    tbody tr:last-child td { border-bottom: none; }
    .empty-row td { text-align: center; color: #64748b; padding: 40px; }

    /* Botón quitar */
    .btn-remove {
        padding: 6px 12px; background: #fef2f2; color: #b91c1c;
        border: 1px solid #fecaca; border-radius: 6px; font-size: 13px; cursor: pointer;
    }
    .btn-remove:hover { background: #fee2e2; }

    /* Sidebar card */
    .summary-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(37,99,235,0.08);
        padding: 24px;
    }
    .summary-card h2 { font-size: 17px; font-weight: 700; color: #1e3a8a; margin-bottom: 16px; }
    .summary-row { display: flex; justify-content: space-between; font-size: 14px; color: #475569; margin-bottom: 10px; }
    .summary-total { display: flex; justify-content: space-between; font-size: 17px; font-weight: 700; color: #1d4ed8; border-top: 1px solid #e0e7ff; padding-top: 12px; margin-top: 4px; }
    .field-label { display: block; font-size: 13px; font-weight: 600; color: #1e3a8a; margin: 16px 0 6px; }
    .entrega-opts { display: flex; gap: 10px; }
    .entrega-opt {
        flex: 1; padding: 10px;
        border: 2px solid #c7d2fe; border-radius: 8px;
        text-align: center; font-size: 13px; font-weight: 600; color: #1e3a8a;
        cursor: pointer; transition: all 0.15s;
    }
    .entrega-opt input { display: none; }
    .entrega-opt:has(input:checked),
    .entrega-opt.selected { border-color: #1d4ed8; background: #eff6ff; color: #1d4ed8; }
    .btn-checkout {
        display: block; width: 100%; margin-top: 20px;
        padding: 12px; background: #1d4ed8; color: #fff;
        border: none; border-radius: 8px;
        font-size: 15px; font-weight: 600; cursor: pointer;
    }
    .btn-checkout:hover { background: #1e40af; }
    .btn-checkout:disabled { background: #93c5fd; cursor: not-allowed; }

    /* Error de sesión (stock insuficiente) */
    .alert-error {
        display: flex; gap: 10px; align-items: flex-start;
        background: #fef2f2; color: #b91c1c;
        border: 1px solid #fecaca;
        padding: 14px 18px; border-radius: 10px; margin-bottom: 24px; font-size: 14px;
    }
    .alert-error strong { display: block; margin-bottom: 2px; }
</style>

<h1 class="page-title">Mi Carrito</h1>

{{-- Alerta de error de sesión (stock insuficiente, etc.) --}}
@if($errors->any())
    <div class="alert-error">
        <div>
            <strong>No se pudo completar la acción</strong>
            @foreach($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    </div>
@endif

<div class="layout">
    {{-- Tabla de productos --}}
    <div class="tabla-wrap">
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Quitar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($detalles as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre ?? 'Producto eliminado' }}</td>
                    <td>${{ number_format($detalle->producto->precio ?? 0, 2) }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>${{ number_format(($detalle->producto->precio ?? 0) * $detalle->cantidad, 2) }}</td>
                    <td>
                        <form action="{{ route('carrito.eliminar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_producto" value="{{ $detalle->id_producto }}">
                            <button type="submit" class="btn-remove">Quitar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr class="empty-row">
                    <td colspan="5">Tu carrito está vacío.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Resumen y checkout --}}
    <div class="sidebar">
        <div class="summary-card">
            <h2>Resumen del pedido</h2>

            <div class="summary-row">
                <span>Artículos</span>
                <span>{{ $detalles->sum('cantidad') }}</span>
            </div>
            <div class="summary-total">
                <span>Total</span>
                <span>${{ number_format($detalles->sum(fn($d) => ($d->producto->precio ?? 0) * $d->cantidad), 2) }}</span>
            </div>

            <form action="{{ route('carrito.checkout') }}" method="POST">
                @csrf
                <span class="field-label">Tipo de entrega</span>
                <div class="entrega-opts">
                    <label class="entrega-opt">
                        <input type="radio" name="tipo_entrega" value="Local" required> Local
                    </label>
                    <label class="entrega-opt">
                        <input type="radio" name="tipo_entrega" value="Domicilio"> Domicilio
                    </label>
                </div>

                <button type="submit" class="btn-checkout" {{ $detalles->isEmpty() ? 'disabled' : '' }}>
                    Realizar pedido
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Resalta visualmente la opción de entrega seleccionada
    document.querySelectorAll('.entrega-opt input').forEach(radio => {
        radio.addEventListener('change', () => {
            document.querySelectorAll('.entrega-opt').forEach(l => l.classList.remove('selected'));
            radio.closest('.entrega-opt').classList.add('selected');
        });
    });
</script>
@endpush
@endsection

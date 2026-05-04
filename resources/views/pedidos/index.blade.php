@extends('layouts.app')
@section('title', 'Pedidos')

@section('content')
<style>
    .page-title { font-size: 24px; font-weight: 700; color: #1e3a8a; margin-bottom: 24px; }
    table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(37,99,235,0.08); }
    thead { background: #1d4ed8; }
    thead th { padding: 14px 16px; text-align: left; color: #fff; font-size: 13px; font-weight: 600; }
    tbody td { padding: 14px 16px; font-size: 14px; color: #1e293b; border-bottom: 1px solid #e0e7ff; vertical-align: middle; }
    tbody tr:last-child td { border-bottom: none; }
    .empty { text-align: center; color: #64748b; padding: 40px; }

    /* Estado badges */
    .badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .badge-Creado        { background: #f8faff; color: #475569; border: 1px solid #e2e8f0; }
    .badge-Pagado        { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .badge-Preparacion   { background: #fef9c3; color: #854d0e; border: 1px solid #fde68a; }
    .badge-Camino        { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }
    .badge-Entregado     { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }

    /* Botones de avance por rol */
    .btn-accion {
        padding: 8px 18px;
        border: none; border-radius: 7px;
        font-size: 13px; font-weight: 600; cursor: pointer;
        background: #1d4ed8; color: #fff;
    }
    .btn-accion:hover { background: #1e40af; }
    .btn-accion.repartidor { background: #0f766e; }
    .btn-accion.repartidor:hover { background: #0d6460; }
    .no-action { font-size: 13px; color: #94a3b8; }
</style>

<h1 class="page-title">
    @if(auth()->user()->rol === 'Cliente') Mis Pedidos
    @elseif(auth()->user()->rol === 'Empleado') Gestión de Pedidos
    @elseif(auth()->user()->rol === 'Repartidor') Pedidos para Entrega
    @else Todos los Pedidos
    @endif
</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Entrega</th>
            <th>Estado</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pedidos as $pedido)
        @php
            $rol    = auth()->user()->rol;
            $estado = $pedido->estado;
        @endphp
        <tr>
            <td>{{ $pedido->id_pedido }}</td>
            <td>{{ $pedido->cliente->nombre ?? $pedido->id_cliente }}</td>
            <td>{{ \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y') }}</td>
            <td>${{ number_format($pedido->total, 2) }}</td>
            <td>{{ $pedido->tipo_entrega }}</td>
            <td>
                @php
                    $badgeClass = match($estado) {
                        'Creado'         => 'badge-Creado',
                        'Pagado'         => 'badge-Pagado',
                        'En Preparación' => 'badge-Preparacion',
                        'En Camino'      => 'badge-Camino',
                        'Entregado'      => 'badge-Entregado',
                        default          => 'badge-Creado',
                    };
                @endphp
                <span class="badge {{ $badgeClass }}">{{ $estado }}</span>
            </td>
            <td>
                @php
                    // Determinar qué acción puede realizar cada rol en cada estado
                    $accion = null;
                    if ($rol === 'Cliente' && $estado === 'Creado') {
                        $accion = ['label' => 'Marcar pagado', 'route' => route('pedidos.pagar', $pedido->id_pedido), 'class' => ''];
                    } elseif (in_array($rol, ['Empleado', 'Administrador']) && $estado === 'Pagado') {
                        $accion = ['label' => 'Iniciar preparación', 'route' => route('pedidos.preparar', $pedido->id_pedido), 'class' => ''];
                    } elseif (in_array($rol, ['Empleado', 'Administrador']) && $estado === 'En Preparación') {
                        $accion = ['label' => 'Listo para envío', 'route' => route('pedidos.enviar', $pedido->id_pedido), 'class' => ''];
                    } elseif ($rol === 'Repartidor' && $estado === 'En Camino') {
                        $accion = ['label' => 'Marcar entregado', 'route' => route('pedidos.entregar', $pedido->id_pedido), 'class' => 'repartidor'];
                    }
                @endphp

                @if($accion)
                    @if($estado === 'En Preparación' && in_array($rol, ['Empleado', 'Administrador']))
                        {{-- El envío requiere id_repartidor; mostramos un mini-form con select --}}
                        <form action="{{ $accion['route'] }}" method="POST" style="display:flex;gap:6px;align-items:center;">
                            @csrf
                            <select name="id_repartidor" required style="padding:6px 10px;border:1.5px solid #c7d2fe;border-radius:6px;font-size:13px;">
                                <option value="">Repartidor...</option>
                                @foreach(\App\Models\Usuario::where('rol','Repartidor')->get() as $rep)
                                    <option value="{{ $rep->id_usuario }}">{{ $rep->nombre }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn-accion {{ $accion['class'] }}">{{ $accion['label'] }}</button>
                        </form>
                    @else
                        <form action="{{ $accion['route'] }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-accion {{ $accion['class'] }}">{{ $accion['label'] }}</button>
                        </form>
                    @endif
                @else
                    <span class="no-action">Sin acción disponible</span>
                @endif
            </td>
        </tr>
        @empty
        <tr><td colspan="7" class="empty">No hay pedidos registrados.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection

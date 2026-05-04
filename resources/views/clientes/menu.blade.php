@extends('layouts.app')
@section('title', 'Menú')

@section('content')
<style>
    .page-title { font-size: 24px; font-weight: 700; color: #1e3a8a; margin-bottom: 24px; }
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 20px;
    }
    .card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(37,99,235,0.08);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .card img {
        width: 100%;
        height: 160px;
        object-fit: cover;
    }
    .card-no-img {
        width: 100%;
        height: 160px;
        background: #e0e7ff;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6366f1;
        font-size: 13px;
    }
    .card-body { padding: 16px; flex: 1; display: flex; flex-direction: column; gap: 8px; }
    .card-nombre { font-size: 16px; font-weight: 700; color: #1e293b; }
    .card-precio { font-size: 18px; font-weight: 700; color: #1d4ed8; }
    .card-cat {
        display: inline-block;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 11px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
        border: 1px solid #bfdbfe;
    }
    .stock-badge {
        font-size: 12px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        display: inline-block;
    }
    .stock-ok      { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .stock-low     { background: #fef9c3; color: #854d0e; border: 1px solid #fde68a; }
    .stock-critical{ background: #fef2f2; color: #b91c1c;  border: 1px solid #fecaca; }
    .btn-agregar {
        margin-top: auto;
        padding: 10px;
        background: #1d4ed8;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
    }
    .btn-agregar:hover { background: #1e40af; }
    .empty { text-align: center; color: #64748b; padding: 60px 0; }
</style>

<h1 class="page-title">Menú de productos</h1>

@if($productos->isEmpty())
    <p class="empty">No hay productos disponibles en este momento.</p>
@else
    <div class="grid">
        @foreach($productos as $producto)
        <div class="card">
            @if($producto->imagen_url)
                <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}">
            @else
                <div class="card-no-img">Sin imagen</div>
            @endif
            <div class="card-body">
                <span class="card-cat">{{ $producto->categoria->nombre ?? 'General' }}</span>
                <div class="card-nombre">{{ $producto->nombre }}</div>
                <div class="card-precio">${{ number_format($producto->precio, 2) }}</div>

                {{-- Indicador visual de stock --}}
                @if($producto->stock >= 10)
                    <span class="stock-badge stock-ok">{{ $producto->stock }} disponibles</span>
                @elseif($producto->stock >= 4)
                    <span class="stock-badge stock-low">Pocas unidades: {{ $producto->stock }}</span>
                @else
                    <span class="stock-badge stock-critical">Últimas unidades: {{ $producto->stock }}</span>
                @endif

                <form action="{{ route('carrito.agregar') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_producto" value="{{ $producto->id_producto }}">
                    <input type="hidden" name="cantidad" value="1">
                    <button type="submit" class="btn-agregar">Agregar al carrito</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection

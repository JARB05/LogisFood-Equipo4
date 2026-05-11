@extends('layouts.app')
@section('title', 'Menú - LogisFood')

@section('content')
<style>
    .menu-header { margin-bottom: 28px; }
    .menu-header h1 { font-size: 26px; font-weight: 800; color: #111827; letter-spacing: -0.4px; margin: 0 0 4px; }
    .menu-header p { font-size: 14px; color: #9CA3AF; font-weight: 500; margin: 0; }

    .filter-bar {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 32px;
        flex-wrap: wrap;
    }
    .filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 18px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        border: 1.5px solid #E5E0D8;
        background: #fff;
        color: #6B7280;
        font-family: 'Outfit', sans-serif;
        transition: all 0.18s;
        white-space: nowrap;
    }
    .filter-btn:hover { border-color: #FF6700; color: #FF6700; background: #FFF7F0; }
    .filter-btn.active {
        background: linear-gradient(135deg, #FF6700, #FF8030);
        color: #fff; border-color: transparent;
        box-shadow: 0 4px 12px rgba(255,103,0,0.28);
    }
    .filter-btn .cat-count {
        display: inline-flex; align-items: center; justify-content: center;
        width: 18px; height: 18px; border-radius: 50%;
        font-size: 10px; font-weight: 800;
        background: rgba(0,0,0,0.08);
    }
    .filter-btn.active .cat-count { background: rgba(255,255,255,0.25); }

    .search-wrap { margin-left: auto; position: relative; }
    .search-wrap svg { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9CA3AF; pointer-events: none; }
    .search-input {
        padding: 9px 16px 9px 36px; border-radius: 50px;
        border: 1.5px solid #E5E0D8; background: #fff;
        font-size: 13px; font-weight: 500; color: #111827;
        font-family: 'Outfit', sans-serif; outline: none; width: 220px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .search-input:focus { border-color: #FF6700; box-shadow: 0 0 0 3px rgba(255,103,0,0.10); }
    .search-input::placeholder { color: #C4BAB0; }

    .section-title {
        font-size: 12px; font-weight: 800; color: #9CA3AF;
        text-transform: uppercase; letter-spacing: 0.8px;
        margin: 0 0 16px; display: flex; align-items: center; gap: 10px;
    }
    .section-title::after { content: ''; flex: 1; height: 1.5px; background: #F3EDE4; border-radius: 2px; }

    .cat-section { margin-bottom: 40px; }
    .cat-section.hidden { display: none; }

    .menu-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 20px; }

    .prod-card {
        background: #fff; border-radius: 20px;
        box-shadow: 0 2px 14px rgba(0,0,0,0.06);
        overflow: hidden; display: flex; flex-direction: column;
        transition: transform 0.2s, box-shadow 0.2s;
        border: 1.5px solid #F3EDE4;
    }
    .prod-card:hover:not(.agotado) { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,0.10); }
    .prod-card.hidden { display: none; }

    .prod-card.agotado { opacity: 0.55; filter: grayscale(0.4); }
    .prod-card.agotado .prod-img,
    .prod-card.agotado .prod-no-img { filter: grayscale(0.6); }

    .prod-img { width: 100%; height: 170px; object-fit: cover; }
    .prod-no-img {
        width: 100%; height: 170px; background: #F9F6F1;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        gap: 8px; color: #D1C4B5;
    }

    .prod-body { padding: 16px; flex: 1; display: flex; flex-direction: column; gap: 10px; }
    .prod-cat {
        display: inline-block; background: #FFF7F0; color: #FF6700;
        font-size: 10px; font-weight: 800; padding: 3px 10px; border-radius: 20px;
        border: 1.5px solid #FFD4B3; letter-spacing: 0.4px; text-transform: uppercase; width: fit-content;
    }
    .prod-card.agotado .prod-cat { background: #F3F4F6; color: #9CA3AF; border-color: #E5E7EB; }

    .prod-nombre { font-size: 15px; font-weight: 800; color: #111827; line-height: 1.3; }
    .prod-footer { display: flex; align-items: center; justify-content: space-between; }
    .prod-precio { font-size: 21px; font-weight: 800; color: #FF6700; letter-spacing: -0.5px; }
    .prod-card.agotado .prod-precio { color: #9CA3AF; }

    .stock-low-badge {
        font-size: 11px; font-weight: 700; padding: 3px 9px; border-radius: 20px;
        background: #FFFBEB; color: #B45309; border: 1.5px solid #FDE68A;
    }
    .stock-out-badge {
        font-size: 11px; font-weight: 700; padding: 3px 9px; border-radius: 20px;
        background: #F3F4F6; color: #9CA3AF; border: 1.5px solid #E5E7EB;
    }

    .btn-agregar {
        display: flex; align-items: center; justify-content: center; gap: 7px;
        margin-top: auto; padding: 11px;
        background: linear-gradient(135deg, #FF6700, #FF8030);
        color: #fff; border: none; border-radius: 12px;
        font-size: 13px; font-weight: 700; cursor: pointer; width: 100%;
        font-family: 'Outfit', sans-serif;
        box-shadow: 0 4px 10px rgba(255,103,0,0.22);
        transition: transform 0.15s, box-shadow 0.15s;
    }
    .btn-agregar:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(255,103,0,0.32); }

    .btn-agotado {
        display: flex; align-items: center; justify-content: center; gap: 7px;
        margin-top: auto; padding: 11px;
        background: #F3F4F6; color: #9CA3AF;
        border: none; border-radius: 12px;
        font-size: 13px; font-weight: 700; width: 100%;
        font-family: 'Outfit', sans-serif; cursor: not-allowed;
    }

    .empty-state { text-align: center; padding: 80px 20px; color: #9CA3AF; }
    .empty-state p { font-size: 15px; font-weight: 500; margin: 12px 0 0; }
</style>

<div class="menu-header">
    <h1>Menú</h1>
    <p>Explora nuestros productos por categoría</p>
</div>

@if($productos->isEmpty())
    <div class="empty-state">
        <svg width="56" height="56" fill="none" stroke="#E5E0D8" viewBox="0 0 24 24" style="margin:0 auto">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <p>No hay productos disponibles en este momento.</p>
    </div>
@else
    @php $porCategoria = $productos->groupBy(fn($p) => $p->categoria->nombre ?? 'General'); @endphp

    <div class="filter-bar">
        <button class="filter-btn active" data-cat="todos" onclick="filtrar(this, 'todos')">
            Todos <span class="cat-count">{{ $productos->count() }}</span>
        </button>
        @foreach($porCategoria as $catNombre => $prods)
            <button class="filter-btn" data-cat="{{ Str::slug($catNombre) }}" onclick="filtrar(this, '{{ Str::slug($catNombre) }}')">
                {{ $catNombre }} <span class="cat-count">{{ $prods->count() }}</span>
            </button>
        @endforeach
        <div class="search-wrap">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" class="search-input" placeholder="Buscar producto..." oninput="buscar(this.value)">
        </div>
    </div>

    @foreach($porCategoria as $catNombre => $prods)
        <div class="cat-section" data-section="{{ Str::slug($catNombre) }}">
            <p class="section-title">{{ $catNombre }}</p>
            <div class="menu-grid">
                @foreach($prods as $producto)
                @php $agotado = $producto->stock <= 0; $pocas = $producto->stock > 0 && $producto->stock < 4; @endphp
                <div class="prod-card {{ $agotado ? 'agotado' : '' }}" data-nombre="{{ strtolower($producto->nombre) }}" data-cat="{{ Str::slug($catNombre) }}">
                    @if($producto->imagen_url)
                        <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" class="prod-img">
                    @else
                        <div class="prod-no-img">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                                <line x1="7" y1="2" x2="7" y2="22" stroke="#D1C4B5" stroke-width="2" stroke-linecap="round"/>
                                <line x1="7" y1="2" x2="7" y2="8" stroke="#D1C4B5" stroke-width="4.5" stroke-linecap="round"/>
                                <line x1="17" y1="2" x2="17" y2="22" stroke="#D1C4B5" stroke-width="2" stroke-linecap="round"/>
                                <path d="M14 2v6a3 3 0 0 0 6 0V2" stroke="#D1C4B5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                            </svg>
                            <span style="font-size:11px;font-weight:600;">Sin imagen</span>
                        </div>
                    @endif
                    <div class="prod-body">
                        <span class="prod-cat">{{ $catNombre }}</span>
                        <div class="prod-nombre">{{ $producto->nombre }}</div>
                        <div class="prod-footer">
                            <span class="prod-precio">${{ number_format($producto->precio, 2) }}</span>
                            @if($agotado)
                                <span class="stock-out-badge">Agotado</span>
                            @elseif($pocas)
                                <span class="stock-low-badge">⚠ Últimas unidades</span>
                            @endif
                        </div>
                        @if($agotado)
                            <button type="button" class="btn-agotado" disabled>
                                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                No disponible
                            </button>
                        @else
                            <form action="{{ route('carrito.agregar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_producto" value="{{ $producto->id_producto }}">
                                <input type="hidden" name="cantidad" value="1">
                                <button type="submit" class="btn-agregar">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    Agregar al carrito
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @endforeach
@endif

@push('scripts')
<script>
function filtrar(btn, cat) {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.querySelector('.search-input').value = '';
    document.querySelectorAll('.cat-section').forEach(sec => {
        if (cat === 'todos' || sec.dataset.section === cat) {
            sec.classList.remove('hidden');
            sec.querySelectorAll('.prod-card').forEach(c => c.classList.remove('hidden'));
        } else {
            sec.classList.add('hidden');
        }
    });
}

function buscar(query) {
    const q = query.toLowerCase().trim();
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    document.querySelector('[data-cat="todos"]').classList.add('active');
    document.querySelectorAll('.cat-section').forEach(sec => {
        sec.classList.remove('hidden');
        let visible = 0;
        sec.querySelectorAll('.prod-card').forEach(card => {
            const match = !q || card.dataset.nombre.includes(q);
            card.classList.toggle('hidden', !match);
            if (match) visible++;
        });
        if (visible === 0 && q) sec.classList.add('hidden');
    });
}
</script>
@endpush
@endsection
@extends('layouts.app')
@section('title', 'Categorías - LogisFood')

@section('content')
<style>
    .page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:28px; }
    .page-title { font-size:26px; font-weight:800; color:#111827; letter-spacing:-0.4px; margin:0; }
    .page-title span { color:#FF6700; }
    .btn-new { display:inline-flex; align-items:center; gap:7px; padding:11px 20px; background:linear-gradient(135deg,#FF6700,#FF8030); color:#fff; border:none; border-radius:12px; font-size:14px; font-weight:700; text-decoration:none; cursor:pointer; font-family:'Outfit',sans-serif; box-shadow:0 4px 12px rgba(255,103,0,0.28); transition:transform 0.15s, box-shadow 0.15s; }
    .btn-new:hover { transform:translateY(-1px); box-shadow:0 6px 16px rgba(255,103,0,0.38); }

    .lf-table { width:100%; border-collapse:collapse; background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 2px 16px rgba(0,0,0,0.06); }
    .lf-table thead { background:#111827; }
    .lf-table thead th { padding:14px 20px; text-align:left; color:#fff; font-size:12px; font-weight:700; letter-spacing:0.5px; text-transform:uppercase; }
    .lf-table tbody td { padding:16px 20px; font-size:14px; color:#374151; border-bottom:1px solid #F3EDE4; font-weight:500; }
    .lf-table tbody tr:last-child td { border-bottom:none; }
    .lf-table tbody tr:hover { background:#FAFAF8; transition:background 0.1s; }

    .cat-id { font-size:12px; font-weight:700; color:#9CA3AF; }
    .cat-name { font-weight:700; color:#111827; }

    .acciones { display:flex; gap:8px; }
    .btn-edit { display:inline-flex; align-items:center; gap:5px; padding:7px 14px; background:#F3EDE4; color:#374151; border:1.5px solid #E5E0D8; border-radius:8px; font-size:12px; font-weight:700; text-decoration:none; transition:all 0.15s; }
    .btn-edit:hover { background:#E5E0D8; border-color:#d0c9bc; }
    .btn-del { display:inline-flex; align-items:center; gap:5px; padding:7px 14px; background:#FFF5F5; color:#DC2626; border:1.5px solid #FECACA; border-radius:8px; font-size:12px; font-weight:700; cursor:pointer; font-family:'Outfit',sans-serif; transition:background 0.15s; }
    .btn-del:hover { background:#FEE2E2; }

    .empty td { text-align:center; color:#9CA3AF; padding:60px; font-size:15px; font-weight:500; }
</style>

<div class="page-header">
    <h1 class="page-title">Categorías <span>·</span> Menú</h1>
    <a href="{{ route('categorias.create') }}" class="btn-new">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        Nueva categoría
    </a>
</div>

<table class="lf-table">
    <thead>
        <tr>
            <th style="width:80px;">ID</th>
            <th>Nombre</th>
            <th style="width:160px;">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categorias as $categoria)
        <tr>
            <td><span class="cat-id">#{{ $categoria->id_categoria }}</span></td>
            <td><span class="cat-name">{{ $categoria->nombre }}</span></td>
            <td>
                <div class="acciones">
                    <a href="{{ route('categorias.edit', $categoria->id_categoria) }}" class="btn-edit">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Editar
                    </a>
                    <form action="{{ route('categorias.destroy', $categoria->id_categoria) }}" method="POST" onsubmit="return confirm('¿Eliminar esta categoría?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-del">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Eliminar
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr class="empty"><td colspan="3">No hay categorías registradas.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
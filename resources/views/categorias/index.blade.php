@extends('layouts.app')
@section('title', 'Categorías')

@section('content')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .page-title  { font-size: 24px; font-weight: 700; color: #1e3a8a; }
    .btn-new {
        padding: 10px 20px; background: #1d4ed8; color: #fff;
        border: none; border-radius: 8px; font-size: 14px; font-weight: 600;
        text-decoration: none; cursor: pointer;
    }
    .btn-new:hover { background: #1e40af; }
    table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(37,99,235,0.08); }
    thead { background: #1d4ed8; }
    thead th { padding: 14px 16px; text-align: left; color: #fff; font-size: 13px; font-weight: 600; }
    tbody td { padding: 14px 16px; font-size: 14px; color: #1e293b; border-bottom: 1px solid #e0e7ff; }
    tbody tr:last-child td { border-bottom: none; }
    .acciones { display: flex; gap: 8px; }
    .btn-edit {
        padding: 7px 14px; background: #eff6ff; color: #1d4ed8;
        border: 1px solid #bfdbfe; border-radius: 6px; font-size: 13px; text-decoration: none;
    }
    .btn-edit:hover { background: #dbeafe; }
    .btn-del {
        padding: 7px 14px; background: #fef2f2; color: #b91c1c;
        border: 1px solid #fecaca; border-radius: 6px; font-size: 13px; cursor: pointer;
    }
    .btn-del:hover { background: #fee2e2; }
    .empty { text-align: center; color: #64748b; padding: 40px; }
</style>

<div class="page-header">
    <h1 class="page-title">Categorías</h1>
    <a href="{{ route('categorias.create') }}" class="btn-new">Nueva categoría</a>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categorias as $categoria)
        <tr>
            <td>{{ $categoria->id_categoria }}</td>
            <td>{{ $categoria->nombre }}</td>
            <td>
                <div class="acciones">
                    <a href="{{ route('categorias.edit', $categoria->id_categoria) }}" class="btn-edit">Editar</a>
                    <form action="{{ route('categorias.destroy', $categoria->id_categoria) }}" method="POST" onsubmit="return confirm('¿Eliminar esta categoría?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-del">Eliminar</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="3" class="empty">No hay categorías registradas.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection

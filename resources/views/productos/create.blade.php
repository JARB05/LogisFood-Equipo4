@extends('layouts.app')
@section('title', 'Nuevo producto')

@section('content')
<style>
    .form-card { max-width: 640px; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(37,99,235,0.08); overflow: hidden; }
    .form-card-header { background: #1d4ed8; padding: 20px 28px; }
    .form-card-header h1 { color: #fff; font-size: 20px; font-weight: 700; }
    .form-card-body { padding: 28px; }
    .field { margin-bottom: 18px; }
    label { display: block; margin-bottom: 6px; font-size: 14px; font-weight: 600; color: #1e3a8a; }
    input[type="text"],
    input[type="number"],
    select {
        width: 100%; padding: 11px 14px;
        border: 1.5px solid #c7d2fe; border-radius: 8px;
        font-size: 14px; color: #1e293b; background: #f8faff;
    }
    input:focus, select:focus { outline: none; border-color: #1d4ed8; background: #fff; }
    .errores { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
    .errores ul { margin: 0; padding-left: 18px; }
    .btn-row { display: flex; gap: 12px; margin-top: 8px; }
    .btn-save { padding: 11px 24px; background: #1d4ed8; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; }
    .btn-save:hover { background: #1e40af; }
    .btn-cancel { padding: 11px 24px; background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; border-radius: 8px; font-size: 14px; text-decoration: none; }
    .btn-cancel:hover { background: #dbeafe; }
    .hint { font-size: 12px; color: #64748b; margin-top: 4px; }
</style>

<div class="form-card">
    <div class="form-card-header"><h1>Nuevo producto</h1></div>
    <div class="form-card-body">
        @if($errors->any())
            <div class="errores"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif

        <form action="{{ route('productos.store') }}" method="POST">
            @csrf

            <div class="field">
                <label for="id_producto">ID del producto</label>
                <input type="text" name="id_producto" id="id_producto" value="{{ old('id_producto') }}" required>
            </div>

            <div class="field">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required>
            </div>

            <div class="field">
                <label for="precio">Precio</label>
                <input type="number" step="0.01" min="0" name="precio" id="precio" value="{{ old('precio') }}" required>
            </div>

            <div class="field">
                <label for="stock">Stock</label>
                <input type="number" min="0" name="stock" id="stock" value="{{ old('stock', 0) }}" required>
                <p class="hint">Cantidad de unidades disponibles para la venta.</p>
            </div>

            <div class="field">
                <label for="id_categoria">Categoría</label>
                <select name="id_categoria" id="id_categoria" required>
                    <option value="">Seleccione una categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id_categoria }}" {{ old('id_categoria') == $categoria->id_categoria ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="imagen_url">URL de la imagen</label>
                <input type="text" name="imagen_url" id="imagen_url" value="{{ old('imagen_url') }}">
            </div>

            <div class="btn-row">
                <button type="submit" class="btn-save">Guardar producto</button>
                <a href="{{ route('productos.index') }}" class="btn-cancel">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

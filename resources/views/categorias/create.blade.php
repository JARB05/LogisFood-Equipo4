@extends('layouts.app')
@section('title', 'Nueva categoría')

@section('content')
<style>
    .form-card { max-width: 560px; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(37,99,235,0.08); overflow: hidden; }
    .form-card-header { background: #1d4ed8; padding: 20px 28px; }
    .form-card-header h1 { color: #fff; font-size: 20px; font-weight: 700; }
    .form-card-body { padding: 28px; }
    .field { margin-bottom: 18px; }
    label { display: block; margin-bottom: 6px; font-size: 14px; font-weight: 600; color: #1e3a8a; }
    input[type="text"] { width: 100%; padding: 11px 14px; border: 1.5px solid #c7d2fe; border-radius: 8px; font-size: 14px; color: #1e293b; background: #f8faff; }
    input:focus { outline: none; border-color: #1d4ed8; background: #fff; }
    .errores { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
    .errores ul { margin: 0; padding-left: 18px; }
    .btn-row { display: flex; gap: 12px; margin-top: 8px; }
    .btn-save {
        padding: 11px 24px; background: #1d4ed8; color: #fff;
        border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer;
    }
    .btn-save:hover { background: #1e40af; }
    .btn-cancel {
        padding: 11px 24px; background: #eff6ff; color: #1d4ed8;
        border: 1px solid #bfdbfe; border-radius: 8px; font-size: 14px; text-decoration: none;
    }
    .btn-cancel:hover { background: #dbeafe; }
</style>

<div class="form-card">
    <div class="form-card-header"><h1>Nueva categoría</h1></div>
    <div class="form-card-body">
        @if($errors->any())
            <div class="errores"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif
        <form action="{{ route('categorias.store') }}" method="POST">
            @csrf
            <div class="field">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required autofocus>
            </div>
            <div class="btn-row">
                <button type="submit" class="btn-save">Guardar</button>
                <a href="{{ route('categorias.index') }}" class="btn-cancel">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

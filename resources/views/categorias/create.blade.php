@extends('layouts.app')
@section('title', 'Nueva categoría - LogisFood')

@section('content')
<style>
    .form-wrap { max-width:540px; }
    .breadcrumb { display:flex; align-items:center; gap:8px; font-size:13px; color:#9CA3AF; font-weight:500; margin-bottom:20px; }
    .breadcrumb a { color:#9CA3AF; text-decoration:none; transition:color 0.15s; }
    .breadcrumb a:hover { color:#FF6700; }
    .breadcrumb span { color:#E5E0D8; }

    .form-card { background:#fff; border-radius:20px; overflow:hidden; box-shadow:0 2px 20px rgba(0,0,0,0.07); }
    .form-card-header { background:linear-gradient(135deg,#FF6700,#FF8030); padding:22px 28px; display:flex; align-items:center; gap:12px; }
    .form-card-header .header-icon { width:38px; height:38px; background:rgba(255,255,255,0.2); border-radius:10px; display:flex; align-items:center; justify-content:center; }
    .form-card-header h1 { font-size:18px; font-weight:800; color:#fff; margin:0; }
    .form-card-body { padding:32px 28px; }

    .field { margin-bottom:22px; }
    .field label { display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:8px; letter-spacing:0.4px; text-transform:uppercase; }
    .field input[type="text"] {
        display:block; width:100%; border-radius:12px; border:1.5px solid #E5E0D8;
        background:#FAFAF8; padding:13px 16px; font-size:15px; color:#111827;
        outline:none; box-sizing:border-box; font-family:'Outfit',sans-serif;
        transition:border-color 0.2s, box-shadow 0.2s;
    }
    .field input[type="text"]:focus { border-color:#FF6700; box-shadow:0 0 0 3px rgba(255,103,0,0.10); background:#fff; }

    .errores { background:#FFF5F5; border:1.5px solid #FECACA; border-left:4px solid #EF4444; padding:14px 16px; border-radius:12px; margin-bottom:22px; font-size:13px; color:#991B1B; }
    .errores ul { margin:0; padding-left:18px; }

    .btn-row { display:flex; gap:10px; }
    .btn-save { display:inline-flex; align-items:center; gap:7px; padding:12px 24px; background:linear-gradient(135deg,#FF6700,#FF8030); color:#fff; border:none; border-radius:12px; font-size:14px; font-weight:700; cursor:pointer; font-family:'Outfit',sans-serif; box-shadow:0 4px 12px rgba(255,103,0,0.28); transition:transform 0.15s, box-shadow 0.15s; }
    .btn-save:hover { transform:translateY(-1px); box-shadow:0 6px 16px rgba(255,103,0,0.38); }
    .btn-cancel { display:inline-flex; align-items:center; gap:7px; padding:12px 20px; background:#F3EDE4; color:#6B7280; border:1.5px solid #E5E0D8; border-radius:12px; font-size:14px; font-weight:600; text-decoration:none; transition:background 0.15s; }
    .btn-cancel:hover { background:#E5E0D8; }
</style>

<div class="form-wrap">
    <div class="breadcrumb">
        <a href="{{ route('categorias.index') }}">Categorías</a>
        <span>›</span>
        Nueva categoría
    </div>

    <div class="form-card">
        <div class="form-card-header">
            <div class="header-icon">
                <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            </div>
            <h1>Nueva categoría</h1>
        </div>
        <div class="form-card-body">
            @if($errors->any())
                <div class="errores"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif

            <form action="{{ route('categorias.store') }}" method="POST">
                @csrf
                <div class="field">
                    <label for="nombre">Nombre de la categoría</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" placeholder="Ej. Bebidas, Postres, Entradas..." required autofocus>
                </div>
                <div class="btn-row">
                    <button type="submit" class="btn-save">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Guardar categoría
                    </button>
                    <a href="{{ route('categorias.index') }}" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
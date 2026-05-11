@extends('layouts.app')
@section('title', 'Editar producto - LogisFood')

@section('content')
<style>
    .form-wrap { max-width:620px; }
    .breadcrumb { display:flex; align-items:center; gap:8px; font-size:13px; color:#9CA3AF; font-weight:500; margin-bottom:20px; }
    .breadcrumb a { color:#9CA3AF; text-decoration:none; transition:color 0.15s; }
    .breadcrumb a:hover { color:#FF6700; }
    .breadcrumb span { color:#E5E0D8; }

    .form-card { background:#fff; border-radius:20px; overflow:hidden; box-shadow:0 2px 20px rgba(0,0,0,0.07); }
    .form-card-header { background:#111827; padding:22px 28px; display:flex; align-items:center; gap:12px; }
    .form-card-header .header-icon { width:38px; height:38px; background:rgba(255,255,255,0.1); border-radius:10px; display:flex; align-items:center; justify-content:center; }
    .form-card-header h1 { font-size:18px; font-weight:800; color:#fff; margin:0; }
    .form-card-header .prod-pill { margin-left:auto; background:rgba(255,103,0,0.2); color:#FF8030; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700; }
    .form-card-body { padding:32px 28px; }

    .field-grid { display:grid; grid-template-columns:1fr 1fr; gap:0 20px; }

    .field { margin-bottom:22px; }
    .field label { display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:8px; letter-spacing:0.4px; text-transform:uppercase; }
    .field input[type="text"],
    .field input[type="number"],
    .field select {
        display:block; width:100%; border-radius:12px; border:1.5px solid #E5E0D8;
        background:#FAFAF8; padding:13px 16px; font-size:15px; color:#111827;
        outline:none; box-sizing:border-box; font-family:'Outfit',sans-serif;
        transition:border-color 0.2s, box-shadow 0.2s; appearance:none;
    }
    .field input:focus,
    .field select:focus { border-color:#FF6700; box-shadow:0 0 0 3px rgba(255,103,0,0.10); background:#fff; }
    .field input[readonly] { background:#F3EDE4; color:#9CA3AF; cursor:not-allowed; border-color:#E5E0D8; }
    .field .hint { font-size:12px; color:#9CA3AF; font-weight:500; margin-top:6px; }

    .preview-wrap { margin-top:10px; }
    .img-preview { width:100%; height:140px; object-fit:cover; border-radius:12px; border:1.5px solid #F3EDE4; display:none; }
    .img-placeholder { width:100%; height:140px; background:#F9F6F1; border-radius:12px; border:1.5px dashed #E5E0D8; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:8px; color:#C4BAB0; font-size:12px; font-weight:600; }

    .errores { background:#FFF5F5; border:1.5px solid #FECACA; border-left:4px solid #EF4444; padding:14px 16px; border-radius:12px; margin-bottom:22px; font-size:13px; color:#991B1B; }
    .errores ul { margin:0; padding-left:18px; }

    .btn-row { display:flex; gap:10px; margin-top:8px; }
    .btn-save { display:inline-flex; align-items:center; gap:7px; padding:12px 24px; background:linear-gradient(135deg,#FF6700,#FF8030); color:#fff; border:none; border-radius:12px; font-size:14px; font-weight:700; cursor:pointer; font-family:'Outfit',sans-serif; box-shadow:0 4px 12px rgba(255,103,0,0.28); transition:transform 0.15s, box-shadow 0.15s; }
    .btn-save:hover { transform:translateY(-1px); box-shadow:0 6px 16px rgba(255,103,0,0.38); }
    .btn-cancel { display:inline-flex; align-items:center; gap:7px; padding:12px 20px; background:#F3EDE4; color:#6B7280; border:1.5px solid #E5E0D8; border-radius:12px; font-size:14px; font-weight:600; text-decoration:none; transition:background 0.15s; }
    .btn-cancel:hover { background:#E5E0D8; }

    .select-wrap { position:relative; }
    .select-wrap svg { position:absolute; right:14px; top:50%; transform:translateY(-50%); pointer-events:none; color:#9CA3AF; }
</style>

<div class="form-wrap">
    <div class="breadcrumb">
        <a href="{{ route('productos.index') }}">Productos</a>
        <span>›</span>
        Editar · {{ $producto->nombre }}
    </div>

    <div class="form-card">
        <div class="form-card-header">
            <div class="header-icon">
                <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </div>
            <h1>Editar producto</h1>
            <span class="prod-pill">#{{ $producto->id_producto }}</span>
        </div>
        <div class="form-card-body">
            @if($errors->any())
                <div class="errores"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif

            <form action="{{ route('productos.update', $producto->id_producto) }}" method="POST">
                @csrf @method('PUT')

                <div class="field">
                    <label for="id_producto">ID del producto</label>
                    <input type="text" name="id_producto" id="id_producto" value="{{ old('id_producto', $producto->id_producto) }}" required readonly>
                </div>

                <div class="field">
                    <label for="nombre">Nombre del producto</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $producto->nombre) }}" required autofocus>
                </div>

                <div class="field-grid">
                    <div class="field">
                        <label for="precio">Precio</label>
                        <input type="number" step="0.01" min="0" name="precio" id="precio" value="{{ old('precio', $producto->precio) }}" required>
                    </div>
                    <div class="field">
                        <label for="stock">Stock disponible</label>
                        <input type="number" min="0" name="stock" id="stock" value="{{ old('stock', $producto->stock) }}" required>
                        <p class="hint">Unidades disponibles para la venta.</p>
                    </div>
                </div>

                <div class="field">
                    <label for="id_categoria">Categoría</label>
                    <div class="select-wrap">
                        <select name="id_categoria" id="id_categoria" required>
                            <option value="">Seleccione una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id_categoria }}" {{ old('id_categoria', $producto->id_categoria) == $categoria->id_categoria ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>

                <div class="field">
                    <label for="imagen_url">URL de imagen</label>
                    <input type="text" name="imagen_url" id="imagen_url" value="{{ old('imagen_url', $producto->imagen_url) }}" placeholder="https://..." oninput="previewImg(this.value)">
                    <div class="preview-wrap">
                        <img id="img-preview" class="img-preview" src="" alt="Preview">
                        <div id="img-placeholder" class="img-placeholder">
                            <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Vista previa de imagen
                        </div>
                    </div>
                </div>

                <div class="btn-row">
                    <button type="submit" class="btn-save">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Guardar cambios
                    </button>
                    <a href="{{ route('productos.index') }}" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewImg(url) {
    const preview = document.getElementById('img-preview');
    const placeholder = document.getElementById('img-placeholder');
    if (url) {
        preview.src = url;
        preview.style.display = 'block';
        placeholder.style.display = 'none';
        preview.onerror = () => { preview.style.display = 'none'; placeholder.style.display = 'flex'; };
    } else {
        preview.style.display = 'none';
        placeholder.style.display = 'flex';
    }
}
document.addEventListener('DOMContentLoaded', () => {
    const val = document.getElementById('imagen_url').value;
    if (val) previewImg(val);
});
</script>
@endpush
@endsection
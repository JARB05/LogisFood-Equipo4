@extends('layouts.auth')
@section('title', 'Crear cuenta')

@section('card-header')
    <h1>Crear cuenta</h1>
    <p>Regístrate para comenzar a ordenar.</p>
@endsection

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="field">
            <label for="nombre">Nombre completo</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required autofocus>
        </div>
        <div class="field">
            <label for="email">Correo electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
        </div>
        <div class="field">
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div class="field">
            <label for="password_confirmation">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        {{-- Campo país requerido por la API externa --}}
        <div class="field">
            <label for="pais">País de residencia</label>
            <select name="pais" id="pais" style="width:100%;padding:11px 14px;border:1.5px solid #c7d2fe;border-radius:8px;font-size:14px;color:#1e293b;background:#f8faff;">
                <option value="">Cargando países...</option>
            </select>
        </div>

        <button type="submit" class="btn-primary">Crear cuenta</button>
    </form>
    <div class="links">
        <a href="{{ route('login') }}">Ya tengo cuenta</a>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('pais');
    fetch('https://restcountries.com/v3.1/all?fields=name,cca2')
        .then(r => r.json())
        .then(data => {
            data.sort((a, b) => a.name.common.localeCompare(b.name.common));
            select.innerHTML = '<option value="">Selecciona tu país...</option>';
            data.forEach(p => {
                const opt = document.createElement('option');
                opt.value = p.cca2;
                opt.textContent = p.name.common;
                if ('{{ old('pais') }}' === p.cca2) opt.selected = true;
                select.appendChild(opt);
            });
        })
        .catch(() => { select.innerHTML = '<option value="">Error al cargar países</option>'; });
});
</script>
@endpush

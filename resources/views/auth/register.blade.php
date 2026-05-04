@extends('layouts.auth')

@section('title', 'Crear cuenta — LogisFood')

@section('content')
    <h1 class="text-2xl font-bold text-gray-900 mb-1">Crear cuenta</h1>
    <p class="text-gray-500 text-sm mb-6">Completa el formulario para registrarte. El sistema te asignará el rol de cliente automáticamente.</p>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        {{-- Nombre --}}
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nombre completo</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
        </div>

        {{-- Correo --}}
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Correo electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
        </div>

        {{-- Contraseña --}}
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Contraseña</label>
            <input type="password" name="password" id="password" required
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
        </div>

        {{-- Confirmar contraseña --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
        </div>

        {{-- País (consumido de la API REST Countries) --}}
        <div>
            <label for="pais" class="block text-sm font-semibold text-gray-700 mb-1">País de residencia</label>
            <select name="pais" id="pais"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white">
                <option value="">Cargando países…</option>
            </select>
        </div>

        {{-- Info del país seleccionado --}}
        <div id="info-pais" class="hidden bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="flex items-center gap-3 mb-2">
                <img id="flag-img" src="" alt="Bandera" class="w-10 h-7 object-cover rounded shadow-sm border border-blue-200">
                <span id="country-name" class="font-semibold text-blue-800 text-sm"></span>
            </div>
            <ul class="text-xs text-blue-700 space-y-1">
                <li><span class="font-semibold">Capital:</span> <span id="capital-text"></span></li>
                <li><span class="font-semibold">Moneda:</span> <span id="currency-text"></span></li>
                <li><span class="font-semibold">Idioma(s):</span> <span id="language-text"></span></li>
                <li><span class="font-semibold">Zona horaria:</span> <span id="timezone-text"></span></li>
            </ul>
        </div>

        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl transition text-sm shadow-sm">
            Crear cuenta
        </button>
    </form>

    <div class="mt-5 text-center">
        <a href="{{ route('login') }}" class="text-xs text-blue-600 hover:underline">Ya tengo cuenta — Iniciar sesión</a>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectPais = document.getElementById('pais');
    const infoDiv    = document.getElementById('info-pais');
    let listaPaises  = [];

    fetch('https://restcountries.com/v3.1/all?fields=name,cca2,capital,currencies,languages,timezones,flags')
        .then(r => r.json())
        .then(data => {
            listaPaises = data.sort((a, b) => a.name.common.localeCompare(b.name.common));
            selectPais.innerHTML = '<option value="">Selecciona tu país…</option>';
            listaPaises.forEach(p => {
                const opt = document.createElement('option');
                opt.value = p.cca2;
                opt.textContent = p.name.common;
                selectPais.appendChild(opt);
            });
        })
        .catch(() => { selectPais.innerHTML = '<option value="">Error al cargar países</option>'; });

    selectPais.addEventListener('change', function () {
        if (!this.value) { infoDiv.classList.add('hidden'); return; }
        const p = listaPaises.find(x => x.cca2 === this.value);
        if (!p) return;
        const capital  = p.capital?.[0] ?? 'N/A';
        const moneda   = p.currencies ? (() => { const c = Object.values(p.currencies)[0]; return `${c.name} (${c.symbol})`; })() : 'N/A';
        const idiomas  = p.languages ? Object.values(p.languages).join(', ') : 'N/A';
        const zonas    = p.timezones ? p.timezones.join(', ') : 'N/A';
        document.getElementById('flag-img').src       = p.flags.svg;
        document.getElementById('country-name').textContent  = p.name.common;
        document.getElementById('capital-text').textContent  = capital;
        document.getElementById('currency-text').textContent = moneda;
        document.getElementById('language-text').textContent = idiomas;
        document.getElementById('timezone-text').textContent = zonas;
        infoDiv.classList.remove('hidden');
    });
});
</script>
@endpush

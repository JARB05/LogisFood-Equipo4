@extends('layouts.auth')
@section('title', 'Registro - LogisFood')

@section('content')
<div style="background:#fff; padding:40px 48px; box-shadow:0 8px 40px rgba(0,0,0,0.08); border-radius:24px; width:100%; position:relative;">

    <a href="{{ route('login') }}" style="display:inline-flex; align-items:center; gap:6px; font-size:13px; font-weight:600; color:#9CA3AF; text-decoration:none; margin-bottom:28px; transition:color 0.2s;"
        onmouseover="this.style.color='#111827'"
        onmouseout="this.style.color='#9CA3AF'">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Volver al inicio de sesión
    </a>

    <div style="text-align:center; margin-bottom:32px;">
        <div style="display:inline-flex; align-items:center; justify-content:center; width:56px; height:56px; background:linear-gradient(135deg,#FF6700,#FF8C3A); border-radius:16px; box-shadow:0 6px 20px rgba(255,103,0,0.30); margin-bottom:16px;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <line x1="7" y1="2" x2="7" y2="22" stroke="white" stroke-width="2.2" stroke-linecap="round"/>
                <line x1="7" y1="2" x2="7" y2="8" stroke="white" stroke-width="5" stroke-linecap="round"/>
                <line x1="17" y1="2" x2="17" y2="22" stroke="white" stroke-width="2.2" stroke-linecap="round"/>
                <path d="M14 2v6a3 3 0 0 0 6 0V2" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            </svg>
        </div>
        <h1 style="font-size:24px; font-weight:800; color:#111827; letter-spacing:-0.4px; margin:0 0 4px;">Crear una cuenta</h1>
        <p style="font-size:14px; color:#9CA3AF; font-weight:500; margin:0;">LogisFood · Regístrate gratis</p>
    </div>

    <form method="POST" action="{{ route('register') }}" style="display:flex; flex-direction:column; gap:16px;">
        @csrf

        <div>
            <label style="display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:7px; letter-spacing:0.4px; text-transform:uppercase;">Nombre Completo</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Tu nombre completo" required autofocus
                style="display:block; width:100%; border-radius:12px; border:1.5px solid #E5E0D8; background:#FAFAF8; padding:13px 16px; font-size:14px; color:#111827; outline:none; box-sizing:border-box; font-family:'Outfit',sans-serif;"
                onfocus="this.style.borderColor='#FF6700';this.style.boxShadow='0 0 0 3px rgba(255,103,0,0.10)'"
                onblur="this.style.borderColor='#E5E0D8';this.style.boxShadow='none'">
        </div>

        <div>
            <label style="display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:7px; letter-spacing:0.4px; text-transform:uppercase;">Correo Electrónico</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="tu@email.com" required
                style="display:block; width:100%; border-radius:12px; border:1.5px solid #E5E0D8; background:#FAFAF8; padding:13px 16px; font-size:14px; color:#111827; outline:none; box-sizing:border-box; font-family:'Outfit',sans-serif;"
                onfocus="this.style.borderColor='#FF6700';this.style.boxShadow='0 0 0 3px rgba(255,103,0,0.10)'"
                onblur="this.style.borderColor='#E5E0D8';this.style.boxShadow='none'">
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:7px; letter-spacing:0.4px; text-transform:uppercase;">Contraseña</label>
                <input type="password" name="password" placeholder="••••••••" required
                    style="display:block; width:100%; border-radius:12px; border:1.5px solid #E5E0D8; background:#FAFAF8; padding:13px 16px; font-size:14px; color:#111827; outline:none; box-sizing:border-box; font-family:'Outfit',sans-serif;"
                    onfocus="this.style.borderColor='#FF6700';this.style.boxShadow='0 0 0 3px rgba(255,103,0,0.10)'"
                    onblur="this.style.borderColor='#E5E0D8';this.style.boxShadow='none'">
            </div>
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:7px; letter-spacing:0.4px; text-transform:uppercase;">Confirmar</label>
                <input type="password" name="password_confirmation" placeholder="••••••••" required
                    style="display:block; width:100%; border-radius:12px; border:1.5px solid #E5E0D8; background:#FAFAF8; padding:13px 16px; font-size:14px; color:#111827; outline:none; box-sizing:border-box; font-family:'Outfit',sans-serif;"
                    onfocus="this.style.borderColor='#FF6700';this.style.boxShadow='0 0 0 3px rgba(255,103,0,0.10)'"
                    onblur="this.style.borderColor='#E5E0D8';this.style.boxShadow='none'">
            </div>
        </div>

        <div style="border-top:1.5px solid #F3EDE4; padding-top:20px; margin-top:4px;">
            <div style="display:flex; align-items:center; gap:8px; margin-bottom:14px;">
                <div style="width:24px; height:24px; background:#FFF7F0; border-radius:6px; display:flex; align-items:center; justify-content:center;">
                    <svg width="13" height="13" fill="none" stroke="#FF6700" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <span style="font-size:13px; font-weight:700; color:#FF6700; text-transform:uppercase; letter-spacing:0.5px;">Información Geográfica</span>
            </div>

            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:7px; letter-spacing:0.4px; text-transform:uppercase;">País de Residencia</label>
                <select name="pais" id="pais" required
                    style="display:block; width:100%; border-radius:12px; border:1.5px solid #E5E0D8; background:#FAFAF8; padding:13px 16px; font-size:14px; color:#111827; outline:none; box-sizing:border-box; appearance:none; font-family:'Outfit',sans-serif; cursor:pointer;"
                    onfocus="this.style.borderColor='#FF6700';this.style.boxShadow='0 0 0 3px rgba(255,103,0,0.10)'"
                    onblur="this.style.borderColor='#E5E0D8';this.style.boxShadow='none'">
                    <option value="">Cargando países...</option>
                </select>
            </div>

            <div id="country-info-card" style="display:none; margin-top:14px; background:#FFF7F0; border:1.5px solid #FFD4B3; border-radius:14px; padding:16px;">
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:12px;">
                    <span id="c-code" style="font-size:11px; font-weight:800; color:#FF6700; background:#FFE8D6; padding:3px 8px; border-radius:6px;"></span>
                    <span id="c-name" style="font-size:15px; font-weight:700; color:#111827;"></span>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                    <div style="font-size:12px; color:#6B7280;"><span style="font-weight:700; color:#374151;">Capital:</span> <span id="c-capital"></span></div>
                    <div style="font-size:12px; color:#6B7280;"><span style="font-weight:700; color:#374151;">Moneda:</span> <span id="c-currency"></span></div>
                    <div style="font-size:12px; color:#6B7280;"><span style="font-weight:700; color:#374151;">Idioma:</span> <span id="c-lang"></span></div>
                    <div style="font-size:12px; color:#6B7280;"><span style="font-weight:700; color:#374151;">Zona:</span> <span id="c-timezone"></span></div>
                </div>
            </div>
        </div>

        <button type="submit"
            style="width:100%; padding:14px; background:linear-gradient(135deg,#FF6700,#FF8030); color:#fff; border:none; border-radius:12px; font-size:15px; font-weight:700; cursor:pointer; box-shadow:0 4px 16px rgba(255,103,0,0.30); margin-top:4px; font-family:'Outfit',sans-serif; letter-spacing:0.2px; transition:transform 0.15s, box-shadow 0.15s;"
            onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 6px 20px rgba(255,103,0,0.40)'"
            onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 16px rgba(255,103,0,0.30)'">
            Crear Cuenta
        </button>
    </form>

    <div style="margin-top:20px; text-align:center; font-size:13px; color:#9CA3AF;">
        <a href="{{ route('login') }}" style="font-weight:700; color:#6B7280; text-decoration:none;">Ya tengo cuenta</a>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('pais');
    const infoCard = document.getElementById('country-info-card');
    let countriesData = {};

    fetch('https://restcountries.com/v3.1/all?fields=name,cca2,capital,currencies,languages,timezones')
        .then(r => r.json())
        .then(data => {
            data.sort((a, b) => a.name.common.localeCompare(b.name.common));
            select.innerHTML = '<option value="">Selecciona tu país...</option>';
            data.forEach(p => {
                countriesData[p.cca2] = p;
                const opt = document.createElement('option');
                opt.value = p.cca2;
                opt.textContent = p.name.common;
                if ('{{ old('pais') }}' === p.cca2) opt.selected = true;
                select.appendChild(opt);
            });
            if (select.value) updateCountryCard(select.value);
        })
        .catch(() => { select.innerHTML = '<option value="">Error al cargar países</option>'; });

    select.addEventListener('change', e => updateCountryCard(e.target.value));

    function updateCountryCard(code) {
        if (!code || !countriesData[code]) { infoCard.style.display = 'none'; return; }
        const c = countriesData[code];
        document.getElementById('c-code').textContent = c.cca2;
        document.getElementById('c-name').textContent = c.name.common;
        document.getElementById('c-capital').textContent = c.capital ? c.capital.join(', ') : 'N/A';
        let cur = 'N/A';
        if (c.currencies) cur = Object.values(c.currencies).map(x => `${x.name} (${x.symbol})`).join(', ');
        document.getElementById('c-currency').textContent = cur;
        document.getElementById('c-lang').textContent = c.languages ? Object.values(c.languages).join(', ') : 'N/A';
        document.getElementById('c-timezone').textContent = c.timezones ? c.timezones[0] : 'N/A';
        infoCard.style.display = 'block';
    }
});
</script>
@endpush
@extends('layouts.auth')
@section('title', 'Recuperar contraseña - LogisFood')

@section('content')
<div style="background:#fff; padding:48px; box-shadow:0 8px 40px rgba(0,0,0,0.08); border-radius:24px; width:100%; position:relative;">

    <a href="{{ route('login') }}" style="display:inline-flex; align-items:center; gap:6px; font-size:13px; font-weight:600; color:#9CA3AF; text-decoration:none; margin-bottom:32px; transition:color 0.2s;"
        onmouseover="this.style.color='#111827'"
        onmouseout="this.style.color='#9CA3AF'">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Volver
    </a>

    <div style="text-align:center; margin-bottom:36px;">
        <div style="display:inline-flex; align-items:center; justify-content:center; width:60px; height:60px; background:linear-gradient(135deg,#FF6700,#FF8C3A); border-radius:18px; box-shadow:0 6px 20px rgba(255,103,0,0.30); margin-bottom:18px;">
            <svg width="26" height="26" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <h1 style="font-size:26px; font-weight:800; color:#111827; letter-spacing:-0.4px; margin:0 0 8px;">Recuperar contraseña</h1>
        <p style="font-size:14px; color:#9CA3AF; font-weight:500; margin:0; line-height:1.5; max-width:320px; margin:0 auto;">Ingresa tu correo y te enviaremos las instrucciones para acceder de nuevo.</p>
    </div>

    <form method="POST" action="{{ route('password.email') }}" style="display:flex; flex-direction:column; gap:20px;">
        @csrf

        <div>
            <label for="email" style="display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:8px; letter-spacing:0.4px; text-transform:uppercase;">Correo Electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="tu@email.com" required autofocus
                style="display:block; width:100%; border-radius:12px; border:1.5px solid #E5E0D8; background:#FAFAF8; padding:14px 18px; font-size:15px; color:#111827; outline:none; box-sizing:border-box; font-family:'Outfit',sans-serif; transition:border-color 0.2s, box-shadow 0.2s;"
                onfocus="this.style.borderColor='#FF6700';this.style.boxShadow='0 0 0 3px rgba(255,103,0,0.12)'"
                onblur="this.style.borderColor='#E5E0D8';this.style.boxShadow='none'">
        </div>

        <button type="submit"
            style="width:100%; padding:15px; background:linear-gradient(135deg,#FF6700,#FF8030); color:#fff; border:none; border-radius:12px; font-size:15px; font-weight:700; cursor:pointer; box-shadow:0 4px 16px rgba(255,103,0,0.35); font-family:'Outfit',sans-serif; transition:transform 0.15s, box-shadow 0.15s;"
            onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 6px 20px rgba(255,103,0,0.45)'"
            onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 16px rgba(255,103,0,0.35)'">
            Enviar enlace de recuperación
        </button>
    </form>
</div>
@endsection
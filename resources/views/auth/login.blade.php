@extends('layouts.auth')
@section('title', 'Iniciar sesión - LogisFood')

@section('content')
<div style="background:#fff; padding:48px; box-shadow: 0 8px 40px rgba(0,0,0,0.08); border-radius:24px; width:100%;">

    <div style="text-align:center; margin-bottom:36px;">
        <div style="display:inline-flex; align-items:center; justify-content:center; width:64px; height:64px; background:linear-gradient(135deg,#FF6700,#FF8C3A); border-radius:18px; box-shadow:0 8px 24px rgba(255,103,0,0.35); margin-bottom:20px;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <line x1="7" y1="2" x2="7" y2="22" stroke="white" stroke-width="2.2" stroke-linecap="round"/>
                <line x1="7" y1="2" x2="7" y2="8" stroke="white" stroke-width="5" stroke-linecap="round"/>
                <line x1="17" y1="2" x2="17" y2="22" stroke="white" stroke-width="2.2" stroke-linecap="round"/>
                <path d="M14 2v6a3 3 0 0 0 6 0V2" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            </svg>
        </div>
        <h1 style="font-size:28px; font-weight:800; color:#111827; letter-spacing:-0.5px; margin:0 0 6px;">LogisFood</h1>
        <p style="font-size:15px; color:#9CA3AF; font-weight:500; margin:0;">Inicia sesión para continuar</p>
    </div>

    <form method="POST" action="{{ route('login.attempt') }}" style="display:flex; flex-direction:column; gap:20px;">
        @csrf

        <div>
            <label for="email" style="display:block; font-size:13px; font-weight:700; color:#374151; margin-bottom:8px; letter-spacing:0.3px; text-transform:uppercase;">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="tu@email.com" required autofocus
                style="display:block; width:100%; border-radius:12px; border:1.5px solid #E5E0D8; background:#FAFAF8; padding:14px 18px; font-size:15px; color:#111827; outline:none; box-sizing:border-box; transition:border-color 0.2s, box-shadow 0.2s; font-family:'Outfit',sans-serif;"
                onfocus="this.style.borderColor='#FF6700';this.style.boxShadow='0 0 0 3px rgba(255,103,0,0.12)'"
                onblur="this.style.borderColor='#E5E0D8';this.style.boxShadow='none'">
        </div>

        <div>
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                <label for="password" style="font-size:13px; font-weight:700; color:#374151; letter-spacing:0.3px; text-transform:uppercase;">Contraseña</label>
                <a href="{{ route('password.request') }}" style="font-size:13px; font-weight:600; color:#FF6700; text-decoration:none;">¿Olvidaste tu contraseña?</a>
            </div>
            <input type="password" name="password" id="password" placeholder="••••••••" required
                style="display:block; width:100%; border-radius:12px; border:1.5px solid #E5E0D8; background:#FAFAF8; padding:14px 18px; font-size:15px; color:#111827; outline:none; box-sizing:border-box; transition:border-color 0.2s, box-shadow 0.2s; font-family:'Outfit',sans-serif;"
                onfocus="this.style.borderColor='#FF6700';this.style.boxShadow='0 0 0 3px rgba(255,103,0,0.12)'"
                onblur="this.style.borderColor='#E5E0D8';this.style.boxShadow='none'">
        </div>

        <button type="submit"
            style="width:100%; padding:15px; background:linear-gradient(135deg,#FF6700,#FF8030); color:#fff; border:none; border-radius:12px; font-size:15px; font-weight:700; cursor:pointer; box-shadow:0 4px 16px rgba(255,103,0,0.35); transition:transform 0.15s, box-shadow 0.15s; margin-top:4px; font-family:'Outfit',sans-serif; letter-spacing:0.2px;"
            onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 6px 20px rgba(255,103,0,0.45)'"
            onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 16px rgba(255,103,0,0.35)'">
            Iniciar Sesión
        </button>
    </form>

    <div style="margin-top:28px; text-align:center; font-size:14px; color:#9CA3AF;">
        ¿No tienes cuenta?
        <a href="{{ route('register') }}" style="font-weight:700; color:#FF6700; text-decoration:none; margin-left:4px;">Regístrate aquí</a>
    </div>
</div>
@endsection
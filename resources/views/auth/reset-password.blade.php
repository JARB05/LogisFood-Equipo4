@extends('layouts.auth')
@section('title', 'Nueva contraseña - LogisFood')

@section('content')
<div style="background:#fff; padding:48px; box-shadow:0 8px 40px rgba(0,0,0,0.08); border-radius:24px; width:100%;">

    <div style="text-align:center; margin-bottom:36px;">
        <div style="display:inline-flex; align-items:center; justify-content:center; width:60px; height:60px; background:linear-gradient(135deg,#1e293b,#334155); border-radius:18px; box-shadow:0 6px 20px rgba(30,41,59,0.25); margin-bottom:18px;">
            <svg width="26" height="26" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
        </div>
        <h1 style="font-size:26px; font-weight:800; color:#111827; letter-spacing:-0.4px; margin:0 0 8px;">Nueva contraseña</h1>
        <p style="font-size:14px; color:#9CA3AF; font-weight:500; margin:0;">Establece una contraseña segura para tu cuenta.</p>
    </div>

    <form method="POST" action="{{ route('password.update') }}" style="display:flex; flex-direction:column; gap:20px;">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label for="email" style="display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:8px; letter-spacing:0.4px; text-transform:uppercase;">Correo Electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email', $email) }}" required readonly
                style="display:block; width:100%; border-radius:12px; border:1.5px solid #E5E0D8; background:#F3F4F6; padding:14px 18px; font-size:15px; color:#9CA3AF; outline:none; box-sizing:border-box; font-family:'Outfit',sans-serif; cursor:not-allowed;">
        </div>

        <div>
            <label for="password" style="display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:8px; letter-spacing:0.4px; text-transform:uppercase;">Nueva contraseña</label>
            <input type="password" name="password" id="password" placeholder="••••••••" required autofocus
                style="display:block; width:100%; border-radius:12px; border:1.5px solid #E5E0D8; background:#FAFAF8; padding:14px 18px; font-size:15px; color:#111827; outline:none; box-sizing:border-box; font-family:'Outfit',sans-serif; transition:border-color 0.2s, box-shadow 0.2s;"
                onfocus="this.style.borderColor='#FF6700';this.style.boxShadow='0 0 0 3px rgba(255,103,0,0.12)'"
                onblur="this.style.borderColor='#E5E0D8';this.style.boxShadow='none'">
        </div>

        <div>
            <label for="password_confirmation" style="display:block; font-size:12px; font-weight:700; color:#374151; margin-bottom:8px; letter-spacing:0.4px; text-transform:uppercase;">Confirmar nueva contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" required
                style="display:block; width:100%; border-radius:12px; border:1.5px solid #E5E0D8; background:#FAFAF8; padding:14px 18px; font-size:15px; color:#111827; outline:none; box-sizing:border-box; font-family:'Outfit',sans-serif; transition:border-color 0.2s, box-shadow 0.2s;"
                onfocus="this.style.borderColor='#FF6700';this.style.boxShadow='0 0 0 3px rgba(255,103,0,0.12)'"
                onblur="this.style.borderColor='#E5E0D8';this.style.boxShadow='none'">
        </div>

        <button type="submit"
            style="width:100%; padding:15px; background:linear-gradient(135deg,#1e293b,#334155); color:#fff; border:none; border-radius:12px; font-size:15px; font-weight:700; cursor:pointer; box-shadow:0 4px 16px rgba(30,41,59,0.25); font-family:'Outfit',sans-serif; transition:transform 0.15s, box-shadow 0.15s; margin-top:4px;"
            onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 6px 20px rgba(30,41,59,0.35)'"
            onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 16px rgba(30,41,59,0.25)'">
            Actualizar credenciales
        </button>
    </form>
</div>
@endsection
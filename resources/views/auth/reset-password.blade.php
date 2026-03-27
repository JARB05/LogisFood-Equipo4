@extends('layouts.auth')

@section('title', 'Restablecer contraseña')

@section('content')
    <h1>Nueva contraseña</h1>
    <p>Escribe tu nueva contraseña.</p>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <label for="email">Correo</label>
        <input type="email" name="email" id="email" value="{{ old('email', $email) }}" required>

        <label for="password">Nueva contraseña</label>
        <input type="password" name="password" id="password" required>

        <label for="password_confirmation">Confirmar contraseña</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>

        <button type="submit">Actualizar contraseña</button>
    </form>

    <div class="links">
        <a href="{{ route('login') }}">Volver al login</a>
    </div>
@endsection
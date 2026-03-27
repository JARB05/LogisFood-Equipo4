@extends('layouts.auth')

@section('title', 'Iniciar sesión')

@section('content')
    <h1>Iniciar sesión</h1>
    <p>Accede con tu correo y contraseña.</p>

    <form method="POST" action="{{ route('login.attempt') }}">
        @csrf

        <label for="email">Correo</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required>

        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Entrar</button>
    </form>

    <div class="links">
        <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
    </div>
@endsection 
@extends('layouts.auth')
@section('title', 'Iniciar sesión')

@section('card-header')
    <h1>Iniciar sesión</h1>
    <p>Accede con tu correo y contraseña.</p>
@endsection

@section('content')
    <form method="POST" action="{{ route('login.attempt') }}">
        @csrf
        <div class="field">
            <label for="email">Correo electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="field">
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit" class="btn-primary">Entrar</button>
    </form>
    <div class="links">
        <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
        <a href="{{ route('register') }}">Crear cuenta</a>
    </div>
@endsection

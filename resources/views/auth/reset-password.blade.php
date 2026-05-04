@extends('layouts.auth')
@section('title', 'Restablecer contraseña')

@section('card-header')
    <h1>Nueva contraseña</h1>
    <p>Escribe y confirma tu nueva contraseña.</p>
@endsection

@section('content')
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="field">
            <label for="email">Correo electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email', $email) }}" required autofocus>
        </div>
        <div class="field">
            <label for="password">Nueva contraseña</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div class="field">
            <label for="password_confirmation">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <button type="submit" class="btn-primary">Actualizar contraseña</button>
    </form>
    <div class="links">
        <a href="{{ route('login') }}">Volver al login</a>
    </div>
@endsection

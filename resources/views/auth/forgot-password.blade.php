@extends('layouts.auth')

@section('title', 'Recuperar contraseña')

@section('content')
    <h1>Recuperar contraseña</h1>
    <p>Escribe tu correo y te enviaremos un enlace.</p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <label for="email">Correo</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required>

        <button type="submit">Enviar enlace</button>
    </form>

    <div class="links">
        <a href="{{ route('login') }}">Volver al login</a>
    </div>
@endsection
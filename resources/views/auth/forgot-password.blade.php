@extends('layouts.auth')
@section('title', 'Recuperar contraseña')

@section('card-header')
    <h1>Recuperar contraseña</h1>
    <p>Te enviaremos un enlace a tu correo.</p>
@endsection

@section('content')
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="field">
            <label for="email">Correo electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
        </div>
        <button type="submit" class="btn-primary">Enviar enlace</button>
    </form>
    <div class="links">
        <a href="{{ route('login') }}">Volver al login</a>
    </div>
@endsection

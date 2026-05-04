@extends('layouts.auth')

@section('title', 'Iniciar sesión — LogisFood')

@section('content')
    <h1 class="text-2xl font-bold text-gray-900 mb-1">Bienvenido de vuelta</h1>
    <p class="text-gray-500 text-sm mb-6">Ingresa con tu correo y contraseña.</p>

    <form method="POST" action="{{ route('login.attempt') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Correo electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Contraseña</label>
            <input type="password" name="password" id="password" required
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
        </div>

        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl transition text-sm shadow-sm">
            Iniciar sesión
        </button>
    </form>

    <div class="flex justify-between mt-5 text-xs text-blue-600">
        <a href="{{ route('password.request') }}" class="hover:underline">¿Olvidaste tu contraseña?</a>
        <a href="{{ route('register') }}" class="hover:underline">Crear cuenta</a>
    </div>
@endsection

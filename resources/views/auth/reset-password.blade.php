@extends('layouts.auth')

@section('title', 'Nueva contraseña — LogisFood')

@section('content')
    <h1 class="text-2xl font-bold text-gray-900 mb-1">Nueva contraseña</h1>
    <p class="text-gray-500 text-sm mb-6">Escribe tu nueva contraseña para restablecer el acceso.</p>

    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Correo electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email', $email) }}" required
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Nueva contraseña</label>
            <input type="password" name="password" id="password" required
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
        </div>

        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl transition text-sm shadow-sm">
            Actualizar contraseña
        </button>
    </form>

    <div class="mt-5 text-center">
        <a href="{{ route('login') }}" class="text-xs text-blue-600 hover:underline">← Volver al login</a>
    </div>
@endsection

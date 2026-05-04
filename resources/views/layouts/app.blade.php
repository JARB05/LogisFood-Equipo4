<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LogisFood')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-50 text-gray-800">

    {{-- Barra de navegación superior --}}
    <nav class="bg-blue-700 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="{{ url('/') }}" class="flex items-center gap-2 text-white font-bold text-lg">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    LogisFood
                </a>

                {{-- Menú según rol --}}
                <div class="hidden md:flex items-center gap-1">
                    @auth
                        @if(auth()->user()->rol === 'Administrador' || auth()->user()->rol === 'Empleado')
                            <a href="{{ route('productos.index') }}"
                               class="text-blue-100 hover:text-white hover:bg-blue-600 px-3 py-2 rounded-lg text-sm transition">
                                Productos
                            </a>
                        @endif

                        @if(auth()->user()->rol === 'Administrador')
                            <a href="{{ route('admin.dashboard') }}"
                               class="text-blue-100 hover:text-white hover:bg-blue-600 px-3 py-2 rounded-lg text-sm transition">
                                Usuarios
                            </a>
                        @endif

                        @if(auth()->user()->rol === 'Cliente')
                            <a href="{{ route('clientes.menu') }}"
                               class="text-blue-100 hover:text-white hover:bg-blue-600 px-3 py-2 rounded-lg text-sm transition">
                                Menú
                            </a>
                            <a href="{{ route('carrito.index') }}"
                               class="text-blue-100 hover:text-white hover:bg-blue-600 px-3 py-2 rounded-lg text-sm transition">
                                Mi Carrito
                            </a>
                        @endif

                        <a href="{{ route('pedidos.index') }}"
                           class="text-blue-100 hover:text-white hover:bg-blue-600 px-3 py-2 rounded-lg text-sm transition">
                            Pedidos
                        </a>
                    @endauth
                </div>

                {{-- Usuario y logout --}}
                @auth
                <div class="flex items-center gap-3">
                    <span class="text-blue-200 text-sm hidden sm:block">
                        {{ auth()->user()->nombre ?? auth()->user()->name }}
                        <span class="ml-1 bg-blue-800 text-blue-100 text-xs px-2 py-0.5 rounded-full">
                            {{ auth()->user()->rol }}
                        </span>
                    </span>
                    <a href="{{ route('logout') }}"
                       class="bg-white text-blue-700 hover:bg-blue-50 text-sm font-semibold px-4 py-1.5 rounded-lg transition">
                        Salir
                    </a>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Contenido principal --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Flash de éxito --}}
        @if(session('success') || session('mensaje'))
            <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 mb-6 text-sm">
                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') ?? session('mensaje') }}</span>
            </div>
        @endif

        {{-- Flash de error de sesión (ej. stock insuficiente en carrito) --}}
        @if(session('error'))
            <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 mb-6 text-sm">
                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>

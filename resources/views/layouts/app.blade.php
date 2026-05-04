<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LogisFood')</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f0f4ff; min-height: 100vh; }

        /* ── Navbar ── */
        nav {
            background: #1d4ed8;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .nav-brand {
            color: #fff;
            font-size: 20px;
            font-weight: 700;
            text-decoration: none;
            letter-spacing: 0.3px;
        }
        .nav-links { display: flex; align-items: center; gap: 4px; }
        .nav-links a {
            color: #bfdbfe;
            text-decoration: none;
            font-size: 14px;
            padding: 7px 14px;
            border-radius: 6px;
            transition: background 0.15s, color 0.15s;
        }
        .nav-links a:hover { background: #1e40af; color: #fff; }
        .nav-right { display: flex; align-items: center; gap: 12px; }
        .nav-user { color: #bfdbfe; font-size: 13px; }
        .nav-user span { background: #1e40af; color: #bfdbfe; font-size: 11px; padding: 2px 8px; border-radius: 20px; margin-left: 6px; }
        .btn-logout {
            background: #fff;
            color: #1d4ed8;
            border: none;
            padding: 6px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }
        .btn-logout:hover { background: #eff6ff; }

        /* ── Main ── */
        main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 24px;
        }

        /* ── Flash messages ── */
        .flash {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 24px;
            font-size: 14px;
        }
        .flash-success { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .flash-error   { background: #fef2f2; color: #b91c1c;  border: 1px solid #fecaca; }
    </style>
</head>
<body>
    <nav>
        <div class="nav-inner">
            <a href="{{ url('/') }}" class="nav-brand">LogisFood</a>

            <div class="nav-links">
                @auth
                    @if(in_array(auth()->user()->rol, ['Administrador', 'Empleado']))
                        <a href="{{ route('productos.index') }}">Productos</a>
                        <a href="{{ route('categorias.index') }}">Categorías</a>
                    @endif

                    @if(auth()->user()->rol === 'Administrador')
                        <a href="{{ route('admin.dashboard') }}">Usuarios</a>
                    @endif

                    @if(auth()->user()->rol === 'Cliente')
                        <a href="{{ route('productos.menu') }}">Menú</a>
                        <a href="{{ route('carrito.index') }}">Mi Carrito</a>
                    @endif

                    <a href="{{ route('pedidos.index') }}">Pedidos</a>
                @endauth
            </div>

            @auth
            <div class="nav-right">
                <span class="nav-user">
                    {{ auth()->user()->nombre ?? auth()->user()->name }}
                    <span>{{ auth()->user()->rol }}</span>
                </span>
                <a href="{{ route('logout') }}" class="btn-logout">Salir</a>
            </div>
            @endauth
        </div>
    </nav>

    <main>
        @if(session('success') || session('mensaje'))
            <div class="flash flash-success">
                {{ session('success') ?? session('mensaje') }}
            </div>
        @endif

        @if(session('error'))
            <div class="flash flash-error">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>

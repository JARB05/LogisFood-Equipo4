<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LogisFood')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Outfit', sans-serif; }
        body {
            background-color: #F9F6F1;
            background-image:
                radial-gradient(circle at 0% 0%, rgba(255,103,0,0.04) 0%, transparent 35%),
                radial-gradient(circle at 100% 100%, rgba(255,103,0,0.03) 0%, transparent 35%);
        }

        .nav-link {
            position: relative;
            font-size: 14px;
            font-weight: 600;
            color: #6B7280;
            text-decoration: none;
            padding: 6px 0;
            transition: color 0.2s;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #FF6700;
            border-radius: 2px;
            transition: width 0.2s;
        }
        .nav-link:hover { color: #FF6700; }
        .nav-link:hover::after { width: 100%; }

        .flash-success {
            display: flex; align-items: center; gap: 12px;
            background: #FFF7F0; border: 1px solid #FFD4B3;
            border-left: 4px solid #FF6700;
            padding: 14px 18px; border-radius: 12px;
            margin-bottom: 28px;
            font-size: 14px; font-weight: 600; color: #92400E;
        }
        .flash-error {
            display: flex; align-items: center; gap: 12px;
            background: #FEF2F2; border: 1px solid #FECACA;
            border-left: 4px solid #EF4444;
            padding: 14px 18px; border-radius: 12px;
            margin-bottom: 28px;
            font-size: 14px; font-weight: 600; color: #991B1B;
        }
    </style>
</head>
<body class="font-sans antialiased text-[#111827] min-h-screen flex flex-col">

    <nav style="background:#fff; border-bottom: 1px solid #F3EDE4; position: sticky; top:0; z-index:50; box-shadow: 0 1px 12px rgba(0,0,0,0.05);">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div style="display:flex; height:64px; justify-content:space-between; align-items:center;">

                <a href="{{ url('/') }}" style="display:flex; align-items:center; gap:10px; text-decoration:none;">
                    <div style="background:#FF6700; width:38px; height:38px; border-radius:10px; display:flex; align-items:center; justify-content:center; box-shadow: 0 4px 12px rgba(255,103,0,0.35);">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="7" y1="2" x2="7" y2="22" stroke="white" stroke-width="2.2" stroke-linecap="round"/>
                            <line x1="7" y1="2" x2="7" y2="8" stroke="white" stroke-width="5" stroke-linecap="round"/>
                            <line x1="17" y1="2" x2="17" y2="22" stroke="white" stroke-width="2.2" stroke-linecap="round"/>
                            <path d="M14 2v6a3 3 0 0 0 6 0V2" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        </svg>
                    </div>
                    <span style="font-size:18px; font-weight:800; color:#111827; letter-spacing:-0.3px;">LogisFood</span>
                </a>

                <div class="hidden md:flex items-center" style="gap:28px;">
                    @auth
                        @if(auth()->user()->rol === 'Administrador')
                        <a href="{{ route('productos.index') }}" class="nav-link">Productos</a>
                        <a href="{{ route('categorias.index') }}" class="nav-link">Categorías</a>
                        @endif
                        @if(auth()->user()->rol === 'Administrador')
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">Usuarios</a>
                        @endif
                        @if(auth()->user()->rol === 'Cliente')
                            <a href="{{ route('productos.menu') }}" class="nav-link">Menú</a>
                            <a href="{{ route('carrito.index') }}" class="nav-link" style="display:flex;align-items:center;gap:6px;">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                Carrito
                            </a>
                        @endif
                        <a href="{{ route('pedidos.index') }}" class="nav-link">Pedidos</a>
                    @endauth
                </div>

                <div style="display:flex; align-items:center; gap:12px;">
                    @auth
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div style="width:32px; height:32px; border-radius:50%; background:linear-gradient(135deg,#FF6700,#FF8C3A); display:flex; align-items:center; justify-content:center;">
                                <span style="font-size:13px; font-weight:700; color:white;">{{ strtoupper(substr(auth()->user()->nombre ?? auth()->user()->name, 0, 1)) }}</span>
                            </div>
                            <div class="hidden sm:block">
                                <p style="font-size:13px; font-weight:700; color:#111827; line-height:1.2;">{{ auth()->user()->nombre ?? auth()->user()->name }}</p>
                                <p style="font-size:11px; font-weight:600; color:#FF6700;">{{ auth()->user()->rol }}</p>
                            </div>
                        </div>
                        <a href="{{ route('logout') }}" style="padding:8px 16px; border:1.5px solid #E5E0D8; border-radius:10px; font-size:13px; font-weight:600; color:#6B7280; text-decoration:none; background:#fff; transition:all 0.2s;" onmouseover="this.style.borderColor='#FF6700';this.style.color='#FF6700'" onmouseout="this.style.borderColor='#E5E0D8';this.style.color='#6B7280'">
                            Salir
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 flex-grow w-full">

        @if(session('success') || session('mensaje'))
            <div class="flash-success">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color:#FF6700"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') ?? session('mensaje') }}
            </div>
        @endif

        @if(session('error'))
            <div class="flash-error">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LogisFood')</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: Arial, sans-serif;
            background: #f0f4ff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            width: 100%;
            max-width: 440px;
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 8px 32px rgba(37,99,235,0.10);
            overflow: hidden;
        }
        .card-header {
            background: #1d4ed8;
            padding: 28px 32px 24px;
        }
        .card-header h1 { color: #fff; font-size: 22px; font-weight: 700; }
        .card-header p  { color: #bfdbfe; font-size: 14px; margin-top: 4px; }
        .card-body { padding: 28px 32px 32px; }
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
        .alert-success { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .alert-error   { background: #fef2f2; color: #b91c1c;  border: 1px solid #fecaca; }
        .alert ul { margin: 0; padding-left: 18px; }
        .field { margin-bottom: 18px; }
        label { display: block; margin-bottom: 6px; font-size: 14px; font-weight: 600; color: #1e3a8a; }
        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%; padding: 11px 14px;
            border: 1.5px solid #c7d2fe; border-radius: 8px;
            font-size: 14px; color: #1e293b; background: #f8faff; outline: none;
        }
        input:focus { border-color: #1d4ed8; background: #fff; }
        .btn-primary {
            display: block; width: 100%; padding: 12px;
            background: #1d4ed8; color: #fff;
            border: none; border-radius: 8px;
            font-size: 15px; font-weight: 600; cursor: pointer; margin-top: 8px;
        }
        .btn-primary:hover { background: #1e40af; }
        .links { margin-top: 20px; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 8px; }
        .links a { color: #1d4ed8; text-decoration: none; font-size: 13px; }
        .links a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">@yield('card-header')</div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-error">
                    <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif
            @yield('content')
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Administración de Accesos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 40px;
        }
        .contenedor {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        h1 { margin-top: 0; color: #333; }
        
        .alerta-exito {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        th { background-color: #f9fafb; font-weight: bold; color: #444; }
        
        select {
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-actualizar { background: #eab308; color: white; }
        .btn-eliminar { background: #dc2626; color: white; margin-left: 8px; }
        
        .acciones { display: flex; align-items: center; }
    </style>
</head>
<body>
    <div class="contenedor">
        <h1>Control de Accesos (Dashboard)</h1>
        
        @if(session('mensaje'))
            <div class="alerta-exito">
                {{ session('mensaje') }}
            </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol Actual</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id_usuario }}</td>
                    <td>{{ $usuario->nombre }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>
                        <form action="{{ route('usuarios.update', $usuario->id_usuario) }}" method="POST" class="acciones">
                            @csrf
                            @method('PUT')
                            <select name="rol" required>
                                <option value="Cliente" {{ $usuario->rol == 'Cliente' ? 'selected' : '' }}>Cliente</option>
                                <option value="Empleado" {{ $usuario->rol == 'Empleado' ? 'selected' : '' }}>Empleado</option>
                                <option value="Repartidor" {{ $usuario->rol == 'Repartidor' ? 'selected' : '' }}>Repartidor</option>
                                <option value="Administrador" {{ $usuario->rol == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                            </select>
                            <button type="submit" class="btn-actualizar" style="margin-left: 8px;">Actualizar</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('usuarios.destroy', $usuario->id_usuario) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-eliminar">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
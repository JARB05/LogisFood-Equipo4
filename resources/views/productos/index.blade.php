<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de productos</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background: #f3f4f6;
        }

        img {
            width: 80px;
            height: auto;
            border-radius: 8px;
        }

        .acciones {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn-crear {
            display: inline-block;
            margin-bottom: 20px;
            background: #2563eb;
            color: white;
        }

        .btn-editar {
            background: #f59e0b;
            color: white;
        }

        .btn-eliminar {
            background: #dc2626;
            color: white;
        }

        .mensaje {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <h1>Productos</h1>

        @if (session('success'))
            <div class="mensaje">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('productos.create') }}" class="btn btn-crear">Nuevo producto</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->id_producto }}</td>
                        <td>
                            @if ($producto->imagen_url)
                                <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}">
                            @else
                                Sin imagen
                            @endif
                        </td>
                        <td>{{ $producto->nombre }}</td>
                        <td>${{ $producto->precio }}</td>
                        <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                        <td>
                            <div class="acciones">
                                <a href="{{ route('productos.edit', $producto->id_producto) }}" class="btn btn-editar">Editar</a>

                                <form action="{{ route('productos.destroy', $producto->id_producto) }}" method="POST" onsubmit="return confirm('¿Eliminar este producto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-eliminar">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
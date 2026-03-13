<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear producto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 40px;
        }

        .contenedor {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        h1 {
            margin-top: 0;
            color: #333;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 6px;
            font-weight: bold;
            color: #444;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .botones {
            margin-top: 25px;
            display: flex;
            gap: 12px;
        }

        button, a {
            padding: 12px 18px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        button {
            background: #2563eb;
            color: white;
        }

        a {
            background: #e5e7eb;
            color: #111827;
        }

        .errores {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <h1>Crear producto</h1>

        @if ($errors->any())
            <div class="errores">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('productos.store') }}" method="POST">
            @csrf

            <label for="id_producto">ID del producto</label>
            <input type="text" name="id_producto" id="id_producto" value="{{ old('id_producto') }}" required>

            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required>

            <label for="precio">Precio</label>
            <input type="number" step="0.01" name="precio" id="precio" value="{{ old('precio') }}" required>

            <label for="categoria">Categoría</label>
            <input type="text" name="categoria" id="categoria" value="{{ old('categoria') }}" required>

            <label for="imagen_url">URL de la imagen</label>
            <input type="text" name="imagen_url" id="imagen_url" value="{{ old('imagen_url') }}">

            <div class="botones">
                <button type="submit">Guardar producto</button>
                <a href="{{ route('productos.index') }}">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
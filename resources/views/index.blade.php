<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio - LogisFood</title>
</head>
<body style="text-align: center; padding: 50px; font-family: Arial;">
    <h1>Bienvenido a la página principal de LogisFood</h1>
    <p>Esta es la vista index.blade.php</p>
    
    <a href="{{ route('contact') }}">
        <button style="padding: 10px 20px; background-color: #ff5722; color: white; border: none; cursor: pointer;">
            Contactar
        </button>
    </a>
</body>
</html>
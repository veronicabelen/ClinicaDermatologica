<!DOCTYPE html>
<html lang="es" class="h-full"> {{-- Importante: h-full en html --}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Centro Estético')</title>
    <!-- CDN de Tailwind CSS (para desarrollo) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Opcional: Si usas clases de Bootstrap como 'card', 'alert', etc., también necesitas Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="font-sans antialiased h-full flex flex-col"> {{-- Importante: h-full y flex flex-col en body --}}
    @yield('content')

    <!-- Opcional: Si usas componentes JS de Bootstrap (alerts dismissible, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
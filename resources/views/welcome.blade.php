<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Clínica Dermatológica Beyava</title> {{-- Título más descriptivo --}}

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    {{-- Puedes añadir otra fuente para encabezados si quieres más contraste, ej. Montserrat --}}
    {{-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&display=swap" rel="stylesheet"> --}}

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
{{-- Clases de color actualizadas para el body --}}

<body class="bg-[#F8F9FA] dark:bg-[#1A1B2A] text-[#212529] dark:text-[#E0E0E0] flex flex-col min-h-screen font-sans">
    {{-- Header con solo el logo/nombre de la clínica (sin la imagen principal ni los botones de login) --}}
    {{-- CAMBIO AQUÍ: justify-center para centrar el contenido del header --}}
    <header class="w-full max-w-7xl mx-auto px-6 py-4 flex items-center justify-center bg-white/80 dark:bg-[#1A1B2A]/80 shadow-md backdrop-blur fixed top-0 left-0 right-0 z-50">
        {{-- Nombre/Logo de la Clínica --}}
        {{-- CAMBIO AQUÍ: text-center para el caso de que el 'a' tag sea más ancho que el texto --}}
        <a href="/" class="text-2xl font-bold text-pink-600 dark:text-pink-400 tracking-wide text-center">
            <span class="text-pink-600 dark:text-pink-400"></span> Clinica Dermatologica Beyava
        </a>
    </header>

    {{-- Contenido principal de la página --}}
    {{-- Añade un padding superior para que el contenido no se oculte detrás del header fijo --}}
    <main class="flex-1 flex flex-col items-center justify-center w-full pt-20 pb-8 px-6 lg:px-0">
        {{-- Contenedor principal para la imagen y los botones --}}
        <div class="flex flex-col items-center gap-6 p-4 bg-white dark:bg-[#2A2B3A] rounded-lg shadow-xl max-w-4xl w-full">
            {{-- Imagen principal más grande (ahora en el main content) --}}
            <img src="{{ asset('images/inicio.jpg') }}" alt="Clínica Dermatológica Beyava" class="w-full max-w-2xl h-auto rounded-lg shadow-md">

            @if (Route::has('login'))
            <nav class="flex items-center gap-4 text-sm mt-4"> {{-- Margin-top para separar de la imagen --}}
                @auth
                <a
                    href="{{ url('/dashboard') }}"
                    class="inline-block px-6 py-2 bg-pink-600 text-white hover:bg-pink-700 dark:bg-pink-500 dark:hover:bg-pink-600 rounded-md text-base leading-normal transition-colors duration-200 font-semibold">
                    Dashboard
                </a>
                @else
                <a
                    href="{{ route('login') }}"
                    class="inline-block px-6 py-2 text-pink-600 border border-pink-600 hover:bg-pink-100 dark:text-pink-400 dark:border-pink-400 dark:hover:bg-[#3B3D4D] rounded-md text-base leading-normal transition-colors duration-200 font-semibold">
                    Iniciar Sesión
                </a>

                @if (Route::has('register'))
                <a
                    href="{{ route('register') }}"
                    class="inline-block px-6 py-2 bg-pink-600 text-white hover:bg-pink-700 dark:bg-pink-500 dark:hover:bg-pink-600 rounded-md text-base leading-normal transition-colors duration-200 font-semibold">
                    Registrarse
                </a>
                @endif
                @endauth
            </nav>
            @endif
        </div>
    </main>

    {{-- Opcional: Un footer simple --}}
    <footer class="w-full max-w-7xl mx-auto px-6 py-4 text-center text-sm text-[#6C757D] dark:text-[#A0AEC0]">
        &copy; {{ date('Y') }} Clínica Beyava. Todos los derechos reservados.
    </footer>
</body>

</html>
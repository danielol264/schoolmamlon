<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Plataforma Académica</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white min-h-screen flex items-center justify-center">

    <div class="text-center px-6 max-w-xl">
       

        <h1 class="text-4xl font-bold mb-4">Bienvenido a la Plataforma Académica</h1>
        <p class="text-gray-300 mb-8 text-lg">Gestiona exámenes, evalúa alumnos y transforma la experiencia educativa con tecnología.</p>

        @if (Route::has('login'))
            <div class="flex justify-center space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="bg-blue-600 hover:bg-blue-700 transition text-white font-semibold py-2 px-6 rounded-lg shadow-lg">
                        Ir al Panel
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="bg-blue-500 hover:bg-blue-600 transition text-white font-semibold py-2 px-6 rounded-lg shadow-lg">
                        Iniciar Sesión
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="bg-gray-700 hover:bg-gray-800 transition text-white font-semibold py-2 px-6 rounded-lg shadow-lg">
                            Registrarse
                        </a>
                    @endif
                @endauth
            </div>
        @endif

        <footer class="mt-16 text-sm text-gray-500">
            © {{ date('Y') }} Universidad XYZ. Todos los derechos reservados.
        </footer>
    </div>
</body>
</html>

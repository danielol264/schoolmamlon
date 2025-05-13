<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a la Escuela</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('img/escuela.jpg') }}')">

    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md shadow-md fixed top-0 w-full flex items-center justify-between px-10 py-4">
        <div class="text-2xl font-bold text-blue-700">
            Escuela Virtual
        </div>
        <div class="flex gap-4">
            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Iniciar sesión</a>
            <a href="{{ route('register') }}" class="text-green-600 hover:text-green-800 font-semibold">Registrarse</a>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="flex flex-col items-center justify-center text-center min-h-screen pt-24">
        <div class="bg-white/80 backdrop-blur-md p-10 rounded-2xl shadow-2xl max-w-2xl">
            <h1 class="text-5xl font-bold text-blue-700 mb-6">Bienvenido a la Plataforma Escolar</h1>
            <p class="text-gray-700 text-lg mb-8">
                Gestiona tus exámenes, tareas y calificaciones fácilmente.
            </p>
            <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-full text-lg transition">
                Empezar ahora
            </a>
        </div>

        <footer class="mt-10 text-gray-400 text-xs">
            &copy; {{ date('Y') }} Escuela Virtual. Todos los derechos reservados.
        </footer>
    </div>

</body>
</html>
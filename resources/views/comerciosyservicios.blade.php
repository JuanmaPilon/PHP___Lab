<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Comercios y Servicios</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body>
    <nav class="bg-gray-800 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-white text-2xl font-bold">Comercios y Servicios</a>
            <ul class="flex space-x-4">
                <li><a href="{{ url('/login') }}" class="text-white hover:text-gray-300">Login</a></li>
                <li><a href="{{ url('/horoscopo') }}" class="text-white hover:text-gray-300">Horóscopo</a></li>
                <li><a href="{{ url('/recetas') }}" class="text-white hover:text-gray-300">Recetas</a></li>
            </ul>
        </div>
    </nav>
    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-bold text-center my-8">Comercios y Servicios</h1>
        <p class="text-center">Aquí puedes mostrar información sobre comercios y servicios.</p>
    </div>
</body>
</html>

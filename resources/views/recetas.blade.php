<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recetas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Comercios y Servicios</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile') }}"> Usuario:
                                {{ Auth::user()->nombreUsuario }}
                            </a>
                        </li>
                        @if(Auth::user()->admin)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Opciones Admin
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                                    <li><a class="dropdown-item" href="{{ url('/admin/create') }}">Crear Clientes</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/admin/anuncio') }}">Crear Anuncio</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/admin/listaUsuarios') }}">Gestionar Clientes</a></li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/contact') }}">Contacto</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/contact') }}">Contacto</a>
                        </li>
                    @endauth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/horoscopo') }}">Horóscopo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/recetas') }}">Recetas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Recetas</h1>

        <form action="{{ url('/recetas') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" class="form-control" name="query" placeholder="Buscar recetas..."
                    value="{{ request('query') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary" style="margin-left: 10px;">Buscar</button>
                </div>
            </div>
        </form>

        @if (isset($error))
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endif

        @if (isset($recipes) && count($recipes) > 0)
            <div class="row ">
                @foreach ($recipes as $recipe)
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body" >
                                <h2 class="card-title">
                                    {{ $recipe['title'] }}
                                </h2>
                                <div class="recipe-details bg-light p-3 mb-3">
                                    <p><strong>Ingredientes:</strong></p>
                                    <p>
                                        {{ $recipe['ingredients'] }}
                                    </p>
                                </div>
                                <div class="recipe-details bg-light p-3 mb-3">
                                    <p><strong>Porciones:</strong></p>
                                    <p>
                                        {{ $recipe['servings'] }}
                                    </p>
                                </div>
                                <div class="recipe-details bg-light p-3">
                                    <p><strong>Instrucciones:</strong></p>
                                    <p>
                                        {!! nl2br(e($recipe['instructions'])) !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            <div class="alert alert-warning" role="alert">
                No se encontraron recetas.
            </div>
        @endif
    </div>

</body>

</html>
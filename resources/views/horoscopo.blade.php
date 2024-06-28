<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horóscopo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                        <a class="nav-link" href="{{ url('/horoscopo') }}">Horoscopo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/recetas') }}">Recetas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Consulta tu Horóscopo</h1>
        <form action="{{ url('/horoscopo') }}" method="GET" class="mb-5">
            <div class="mb-3">
                <label for="sign" class="form-label">Signo del Zodiaco</label>
                <select class="form-select" id="sign" name="sign" required>
                    <option value="Aries">Aries</option>
                    <option value="Taurus">Tauro</option>
                    <option value="Gemini">Géminis</option>
                    <option value="Cancer">Cáncer</option>
                    <option value="Leo">Leo</option>
                    <option value="Virgo">Virgo</option>
                    <option value="Libra">Libra</option>
                    <option value="Scorpio">Escorpio</option>
                    <option value="Sagittarius">Sagitario</option>
                    <option value="Capricorn">Capricornio</option>
                    <option value="Aquarius">Acuario</option>
                    <option value="Pisces">Piscis</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="day" class="form-label">Día</label>
                <select class="form-select" id="day" name="day" required>
                    <option value="TODAY">Hoy</option>
                    <option value="YESTERDAY">Ayer</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Consultar</button>
        </form>

        @if(isset($error))
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @else
            @if(isset($data))
                <div class="card">
                    <div class="card-header">
                    <h5 class="card-title">Horóscopo para {{ $sign }} el {{ $data['date'] }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $data['horoscope_data'] }}</p>
                    </div>
                </div>
            @else
                <div class="alert alert-warning" role="alert">
                    No hay datos disponibles.
                </div>
            @endif
        @endif
    </div>
</body>
</html>

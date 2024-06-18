<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Anuncio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                            <a class="nav-link" href="{{ route('profile')}}">
                                {{ Auth::user()->nombreUsuario }}
                            </a>
                        </li>
                        @if(Auth::user()->admin)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/admin/create') }}">Crear Usuario</a>
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
        <h1 class="text-center">Crear Anuncio</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ url('/admin/anuncio') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="cliente_id" class="form-label">ID Cliente</label>
                <input type="text" class="form-control" id="cliente_id" name="cliente_id" required>
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label">Nombre Negocio</label>
                <input type="text" class="form-control" id="tipo" name="tipo" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="disponible" name="disponible">
                <label for="disponible" class="form-check-label">Disponible</label>
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen</label>
                <input type="file" class="form-control" id="imagen" name="imagen" required onchange="previewImage(event,'#imgPreview')">
                <img id="imgPreview" class="card-img-top" style="max-width: 100px; max-height: 100px;">
            </div>
            <button type="submit" class="btn btn-primary">Crear Anuncio</button>
        </form>
    </div>
</body>
<script>
function previewImage(event, querySelector){
    const input = event.target;
    const imgPreview = document.querySelector(querySelector);
    if(!input.files.length) return;
    const file = input.files[0];
    const objectURL = URL.createObjectURL(file);
    imgPreview.src = objectURL;
}
</script>
</html>


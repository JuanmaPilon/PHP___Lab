<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comercios y Servicios</title>
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
                            <a class="nav-link" href="{{ route('profile')}}">
                                {{ Auth::user()->nombreUsuario }}
                            </a>
                        </li>
                        @if(Auth::user()->admin)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/admin/create') }}">Crear Clientes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/admin/anuncio') }}">Crear Anuncio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/admin/listaUsuarios') }}">Gestionar Clientes</a>
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
        <h1 class="text-center">Comercios y Servicios</h1>
        <div class="row mt-3">
            @foreach($anuncios as $anuncio)
                <div class="col-md-3 mb-3">
                    <div class="card" id="anuncio-{{ $anuncio->id }}">
                        <img src="{{ asset('images/' . $anuncio->imagen) }}" class="card-img-top" alt="Imagen de Anuncio">
                        <div class="card-body">
                            <h5 class="card-title">{{ $anuncio->tipo }}</h5>
                            @auth
                                @if(Auth::user()->admin)
                                    <form action="{{ url('/admin/anuncio/' . $anuncio->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este anuncio?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm float-end">X</button>
                                    </form>
                                @endif
                            @endauth
                            <button class="btn btn-primary btn-sm mt-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $anuncio->id }}" aria-expanded="false" aria-controls="collapse-{{ $anuncio->id }}" onclick="loadClienteData({{ $anuncio->cliente_id }}, {{ $anuncio->id }})">
                                Ver detalles
                            </button>
                            <div class="collapse mt-2" id="collapse-{{ $anuncio->id }}">
                                <div class="card card-body">
                                    <p><strong>Nombre Negocio:</strong> <span id="nombreNegocio-{{ $anuncio->id }}"></span></p>
                                    <p><strong>Descripción:</strong> <span id="descripcion-{{ $anuncio->id }}"></span></p>
                                    <p><strong>Contacto:</strong> <span id="email-{{ $anuncio->id }}"></span></p>
                                    <p><strong>Teléfono:</strong> <span id="telefono-{{ $anuncio->id }}"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function loadClienteData(clienteId, anuncioId) {
            $.ajax({
                url: '/cliente/' + clienteId,
                method: 'GET',
                success: function (data) {
                    $('#nombreNegocio-' + anuncioId).text(data.nombreNegocio);
                    $('#descripcion-' + anuncioId).text(data.descripcion);
                    $('#email-' + anuncioId).text(data.usuario.email);
                    $('#telefono-' + anuncioId).text(data.usuario.telefono);
                },
                error: function (xhr) {
                    alert('Error al obtener los datos del cliente.');
                }
            });
        }
    </script>
</body>
</html>

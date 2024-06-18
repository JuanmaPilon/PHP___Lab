<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comercios y Servicios</title>

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
        <h1 class="text-center">Clientes Registrados</h1>

        <!-- Mostrar usuarios -->
        <div class="mt-5">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre de Negocio</th>
                        <th>Descripcion</th>
                        <th>Nombre Usuario</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Modificar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clientes as $cliente)
                    <tr>
                        <form action="{{ url('/admin/cliente/' . $cliente->id) }}" method="POST"
                        onsubmit="return confirm('¿Estás seguro de que quieres modificar este cliente?');">
                            @csrf
                            @method('PATCH')
                            <td>{{ $cliente->id }}</td>
                            <td><input type="text" name="nombreNegocio" value="{{ $cliente->nombreNegocio }}"></td>
                            <td><input type="text" name="descripcion" value="{{ $cliente->descripcion }}"></td>
                            <td><input type="text" name="nombreUsuario" value="{{ $cliente->usuario->nombreUsuario }}"></td>
                            <td><input type="text" name="telefono" value="{{ $cliente->usuario->telefono }}"></td>
                            <td><input type="email" name="email" value="{{ $cliente->usuario->email }}"></td>
                            <td>
                                <button type="submit" class="btn btn-primary btn-sm">Modificar</button>
                            </td>
                        </form>
                        <td>
                            <form action="{{ url('/admin/cliente/' . $cliente->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar este cliente?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm float-end">X</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay usuarios registrados</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Verifica tu direccion de correo</h1>
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <p class="text-center">Tu correo no esta verificado. Antes de proceder, debes verificarlo</p>
        <p class="text-center">Si no recibiste el mail de verificacion, clickea en el boton de abajo.</p>
        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Reenviar verificacion de mail</button>
            </div>
        </form>
    </div>
</body>
</html>

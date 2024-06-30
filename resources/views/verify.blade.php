<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifica tu correo electrónico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="alert alert-warning text-center" role="alert">
        Por favor, verifica tu correo electrónico antes de continuar.
    </div>
    @if (session('resent'))
        <div class="alert alert-success" role="alert">
            Se ha reenviado un nuevo enlace de verificación a tu correo electrónico.
        </div>
    @endif
    <p class="text-center">
        Hemos enviado un correo electrónico a tu dirección con un enlace de verificación.
        Si no has recibido el correo:
    </p>
    <form action="{{ route('verification.resend') }}" method="POST" class="text-center">
        @csrf
        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">haz clic aquí para reenviar el correo</button>.
    </form>
</div>
</body>
</html>

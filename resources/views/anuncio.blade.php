<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Anuncio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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


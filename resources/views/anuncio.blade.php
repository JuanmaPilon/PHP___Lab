<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Anuncio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Crear Anuncio</h1>
        <form action="{{ url('/admin/anuncio') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="cliente_id" class="form-label">Cliente</label>
                <select class="form-control" id="cliente_id" name="cliente_id" required>
                    <option value="">Seleccione un cliente</option>
                    <!-- Opciones se llenarán dinámicamente con JavaScript -->
                </select>
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label">Nombre del anuncio</label>
                <input type="text" class="form-control" id="tipo" name="tipo" required>
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen</label>
                <input type="file" class="form-control" id="imagen" name="imagen" required>
                <img id="imagen-preview" src="#" alt="Vista previa de la imagen" class="img-fluid mt-3 d-none" />
            </div>
            <button type="submit" class="btn btn-primary">Crear Anuncio</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            // Obtener los clientes y llenar el combobox
            $.ajax({
                url: '/clientes',
                method: 'GET',
                success: function(data) {
                    let clienteSelect = $('#cliente_id');
                    data.forEach(function(cliente) {
                        clienteSelect.append(new Option(cliente.nombreNegocio + ' - ' + cliente.usuario.nombreUsuario, cliente.id));
                    });
                },
                error: function(xhr) {
                    alert('Error al obtener los clientes.');
                }
            });

            // Mostrar vista previa de la imagen seleccionada
            $('#imagen').change(function() {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagen-preview').attr('src', e.target.result).removeClass('d-none');
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
</body>
</html>

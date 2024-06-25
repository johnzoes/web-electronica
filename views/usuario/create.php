<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paso 1: Seleccionar Rol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Crear Usuario - Paso 1</h2>
    <form action="index.php?controller=usuario&action=store" method="POST">
        <div class="form-group">
            <label for="id_rol">Rol:</label>
            <select class="form-control" id="id_rol" name="id_rol" required>
                <option value="">Seleccione un rol</option>
                <option value="2">Asistente</option>
                <option value="3">Profesor</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Siguiente</button>
    </form>
</div>
</body>
</html>

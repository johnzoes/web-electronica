
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paso 2: Completar Datos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Crear Usuario - Paso 2  idrol = <?php echo $_SESSION['id_rol'] ?> </h2>
    <form action="index.php?controller=usuario&action=store_two" method="POST">
        <div class="form-group">
            <label for="nombre_usuario">Nombre de Usuario:</label>
            <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required>
        </div>
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="apellidos">Apellidos:</label>
            <input type="text" class="form-control" id="apellidos" name="apellidos" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <div class="input-group">
                <input type="password" class="form-control" id="password" name="password" required>
                <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                    <i class="bi bi-eye" id="toggleIcon"></i>
                </button>
            </div>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirmar Contraseña:</label>
            <div class="input-group">
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                <button type="button" class="btn btn-outline-secondary" id="toggleConfirmPassword">
                    <i class="bi bi-eye" id="toggleConfirmIcon"></i>
                </button>
            </div>
        </div>
        <div id="asistente-details" style="display: none;">
            <div class="form-group">
                <label for="turno">Turno:</label>
                <select class="form-control" id="turno" name="turno">
                    <option value="" selected disabled>Selecciona un turno</option>
                    <?php foreach($turnos as $turno): ?>

                    <option value="<?php echo $turno['id_turno']?> "><?php echo $turno['nombre']?></option>
                   <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="salon">Salón:</label>

                <select class="form-control" id="salon" name="salon">
                <option value="" selected disabled>Selecciona un salon</option>
                <?php foreach($salones as $salon): ?>
                    <option value="<?php echo $salon['id_salon']?> "><?php echo $salon['nombre_salon']?></option>
                <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>
    // Mostrar u ocultar los campos adicionales para asistente
    var role = "<?php echo $_SESSION['id_rol']; ?>";
    if (role == '2') {
        document.getElementById('asistente-details').style.display = 'block';
    }

    document.getElementById('togglePassword').addEventListener('click', function() {
        var password = document.getElementById('password');
        var icon = document.getElementById('toggleIcon');
        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });

    document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
        var confirmPassword = document.getElementById('confirm_password');
        var icon = document.getElementById('toggleConfirmIcon');
        if (confirmPassword.type === 'password') {
            confirmPassword.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            confirmPassword.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });
</script>
</body>
</html>

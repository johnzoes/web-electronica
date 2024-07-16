<div class="container">
    <h2>Actualizar Profesor</h2>
    <form action="index.php?controller=profesor&action=update&id=<?php echo $usuario['id_usuario']; ?>" method="POST">
        <div class="form-group">

        <div class="form-group">
            <label for="nombre_usuario">Usuario:</label>
            <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" value="<?php echo $usuario['nombre_usuario']; ?>" required>
        </div>


            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>
        </div>

        <div class="form-group">
            <label for="apellidos">Apellido:</label>
            <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $usuario['apellidos']; ?>" required>
        </div>


        <button type="submit" class="btn btn-primary">Actualizar Profesor</button>
    </form>
</div>

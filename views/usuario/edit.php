<div class="container">
    <h2>Actualizar Usuario</h2>
    <form action="index.php?controller=usuario&action=update&id=<?php echo $usuario['id_usuario']; ?>" method="POST">
        <div class="form-group">
            <label for="nombre_usuario">Nombre de Usuario:</label>
            <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" value="<?php echo $usuario['nombre_usuario']; ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="id_rol">ID Rol:</label>
            <input type="text" class="form-control" id="id_rol" name="id_rol" value="<?php echo $usuario['id_rol']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary

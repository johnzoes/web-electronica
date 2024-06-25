<div class="container">
    <h2>Actualizar Rol</h2>
    <form action="index.php?controller=rol&action=update&id=<?php echo $rol['id_rol']; ?>" method="POST">
        <div class="form-group">
            <label for="nombre">Nombre del Rol:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $rol['nombre']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Rol</button>
    </form>
</div>

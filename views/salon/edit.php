<div class="container">
    <h2>Actualizar Salón</h2>
    <form action="index.php?controller=salon&action=update&id=<?php echo $salon['id_salon']; ?>" method="POST">
        <div class="form-group">
            <label for="nombre_salon">Nombre del Salón:</label>
            <input type="text" class="form-control" id="nombre_salon" name="nombre_salon" value="<?php echo $salon['nombre_salon']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Salón</button>
    </form>
</div>

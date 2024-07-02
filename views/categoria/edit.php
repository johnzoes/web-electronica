<div class="container">
    <h2>Actualizar Categoría</h2>
    <form action="index.php?controller=categoria&action=update&id=<?php echo $categoria['id_categoria']; ?>" method="POST">
        <div class="form-group">
            <label for="nombre_categoria">Nombre de la Categoría:</label>
            <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" value="<?php echo $categoria['nombre_categoria']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Categoría</button>
    </form>
</div>

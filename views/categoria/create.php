<div class="container">
    <h2>Crear Categoría</h2>
    <form action="index.php?controller=categoria&action=store" method="POST">
        <div class="form-group">
            <label for="nombre_categoria">Nombre de la Categoría:</label>
            <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear Categoría</button>
    </form>
</div>

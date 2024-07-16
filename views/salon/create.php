<div class="container">
    <h2>Crear Salón</h2>
    <form action="index.php?controller=salon&action=store" method="POST">
        <div class="form-group">
            <label for="nombre_salon">Nombre del Salón:</label>
            <input type="text" class="form-control" id="nombre_salon" name="nombre_salon" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear Salón</button>
    </form>
</div>
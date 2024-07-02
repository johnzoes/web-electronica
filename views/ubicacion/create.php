<h1>Crear Ubicación</h1>
<form action="index.php?controller=ubicacion&action=store" method="POST" class="d-flex flex-column align-items-start">
    <div class="mb-3 d-flex align-items-center">
        <label for="id_salon" class="form-label me-2">Salón:</label>
        <select class="form-select" id="id_salon" name="id_salon" required>
            <option value="" selected disabled>Selecciona</option>
            <?php foreach ($salones as $salon): ?>
                <option value="<?php echo htmlspecialchars($salon['id_salon'], ENT_QUOTES, 'UTF-8'); ?>">
                    <?php echo htmlspecialchars($salon['nombre_salon'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <a href="index.php?controller=salon&action=create" class="btn btn-secondary ms-2">Agregar</a>
    </div>

    <div class="mb-3">
        <label for="nombre_armario" class="form-label">Nombre del Armario:</label>
        <input type="text" class="form-control" id="nombre_armario" name="nombre_armario" required>
    </div>

    <button type="submit" class="btn btn-primary">Crear</button>
</form>
<a href="index.php?controller=ubicacion&action=index" class="btn btn-secondary mt-3">Volver</a>

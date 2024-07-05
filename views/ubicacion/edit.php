<?php if (isset($ubicacion) && isset($salones)): ?>
    <div class="container">
        <h2>Editar Ubicación</h2>
        <form action="index.php?controller=ubicacion&action=update&id=<?php echo htmlspecialchars($ubicacion['id_ubicacion'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
            <div class="mb-3">
                <label for="nombre_armario" class="form-label">Nombre del Armario</label>
                <input type="text" class="form-control" id="nombre_armario" name="nombre_armario" value="<?php echo htmlspecialchars($ubicacion['nombre_armario'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="mb-3">
                <label for="id_salon" class="form-label">Salón</label>
                <select class="form-control" id="id_salon" name="id_salon" required>
                    <?php foreach ($salones as $salon): ?>
                        <option value="<?php echo htmlspecialchars($salon['id_salon'], ENT_QUOTES, 'UTF-8'); ?>" <?php if ($salon['id_salon'] == $ubicacion['id_salon']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($salon['nombre_salon'], ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>
    </div>
<?php else: ?>
    <p>Datos de ubicación no encontrados.</p>
<?php endif; ?>
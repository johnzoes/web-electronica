<div class="container">
    <h2>Lista de Categorías</h2>
    <?php if ($rol != 3): // 3 es el rol de Profesor ?>
        <a href="index.php?controller=categoria&action=create" class="btn btn-success mb-3">Crear Categoría</a>
    <?php endif; ?>
    <div class="row">
        <?php foreach ($categorias as $categoria): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($categoria['nombre_categoria'], ENT_QUOTES, 'UTF-8'); ?></h5>
                        <a href="index.php?controller=item&action=index&id_categoria=<?php echo htmlspecialchars($categoria['id_categoria'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary">Ver Items</a>
                        <?php if ($rol != 3): ?>
                            <a href="index.php?controller=categoria&action=edit&id=<?php echo htmlspecialchars($categoria['id_categoria'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary">Editar</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="container">
    <h2>Lista de Categorías</h2>
    <a href="index.php?controller=categoria&action=create" class="btn btn-success mb-3">Crear Categoría</a>
    <div class="row">
        <?php foreach ($categorias as $categoria): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $categoria['nombre_categoria']; ?></h5>

                        <a href="index.php?controller=categoria&action=edit&id=<?php echo $categoria['id_categoria']; ?>" class="btn btn-primary">Editar</a>
                        <a href="index.php?controller=item&action=index&id_categoria=<?php echo $categoria['id_categoria']; ?>" class="btn btn-primary">Ver Items</a>
                        </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

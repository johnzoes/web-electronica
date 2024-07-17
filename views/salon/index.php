<div class="container">
    
<h2 class="my-4 poppins-bold">Lista de Ubicaciones</h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($salones)): ?>
                <?php foreach ($salones as $salon): ?>
                    <tr>
                        <td><?php echo $salon['id_salon']; ?></td>
                        <td><?php echo $salon['nombre_salon']; ?></td>
                        <td>
                            <a href="index.php?controller=salon&action=edit&id=<?php echo $salon['id_salon']; ?>" class="btn btn-primary">Editar</a>
                            <a href="index.php?controller=salon&action=delete&id=<?php echo $salon['id_salon']; ?>" class="btn btn-danger">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No se encontraron salones.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="index.php?controller=salon&action=create" class="btn btn-primary mb-3 ">Agregar Salón</a>

</div>

<div class="container">
    <h2>Lista de Items</h2>
    <a href="index.php?controller=item&action=create&id_categoria=<?php echo $id_categoria; ?>" class="btn btn-success mb-3">Crear Item</a>
    <table class="table">
        <thead>
            <tr>
                <th>Código BCI</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <!-- Agrega aquí las demás columnas según tus necesidades -->
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($items): ?>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?php echo $item['codigo_bci']; ?></td>
                        <td><?php echo $item['descripcion']; ?></td>
                        <td><?php echo $item['cantidad']; ?></td>
                        <!-- Agrega aquí las demás columnas según tus necesidades -->
                        <td>
                            <a href="index.php?controller=item&action=edit&id=<?php echo $item['id_item']; ?>" class="btn btn-primary">Editar</a>
                            <form action="index.php?controller=item&action=delete&id=<?php echo $item['id_item']; ?>" method="POST" style="display: inline-block;">
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No hay items disponibles</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

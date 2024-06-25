<div class="container">
    <h2>Lista de Detalles de Reserva de Item</h2>

    <a href="index.php?controller=detalle_reserva_item&action=create" class="btn btn-success mb-3">Crear Detalle</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID de Reserva</th>
                <th>ID del Item</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detalles as $detalle): ?>
            <tr>
                <td><?php echo $detalle['id_reserva']; ?></td>
                <td><?php echo $detalle['id_item']; ?></td>
                <td>
                    <a href="index.php?controller=detalle_reserva_item&action=edit&id=<?php echo $detalle['id_detalle']; ?>" class="btn btn-primary">Editar</a>
                    <form action="index.php?controller=detalle_reserva_item&action=delete&id=<?php echo $detalle['id_detalle']; ?>" method="POST" style="display: inline-block;">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>



<div class="container">
    <h2 class="my-4 poppins-bold">Lista de Reservas</h2>
    <a href="index.php?controller=reserva&action=create" class="btn btn-success mb-3">Crear Reserva</a>
    <table class="table-modern">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Cliente</th>
                <th>Fecha de Reserva</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservas as $reserva): ?>
            <tr>
                <td><?php echo htmlspecialchars($reserva['id_reserva'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($reserva['nombre_cliente'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($reserva['fecha_reserva'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <a href="index.php?controller=reserva&action=edit&id=<?php echo htmlspecialchars($reserva['id_reserva'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary btn-sm">
                        <!-- SVG para Editar -->
                    </a>
                    <form action="index.php?controller=reserva&action=delete&id=<?php echo htmlspecialchars($reserva['id_reserva'], ENT_QUOTES, 'UTF-8'); ?>" method="POST" style="display: inline-block;">
                        <button type="submit" class="btn btn-danger btn-sm">
                            <!-- SVG para Eliminar -->
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

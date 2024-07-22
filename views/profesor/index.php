<div class="container">
    <h2 class="my-4 poppins-bold">Lista de Profesores</h2>
    <table class="table-modern">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datos_profesores as $profesor): ?>
                <tr>
                    <td><?php echo htmlspecialchars($profesor['nombre_usuario'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($profesor['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($profesor['apellidos'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <a href="index.php?controller=profesor&action=edit&id=<?php echo htmlspecialchars($profesor['id_usuario'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-warning btn-sm">
                            <!-- SVG para Editar -->
                        </a>
                        <a href="index.php?controller=profesor&action=delete&id=<?php echo htmlspecialchars($profesor['id_usuario'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">
                            <!-- SVG para Eliminar -->
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2 class="my-4 poppins-bold">Notificaciones</h2>
    <ul class="list-group">
        <?php foreach ($notificaciones as $notificacion): ?>
            <li class="list-group-item <?php echo $notificacion['is_read'] ? '' : 'list-group-item-info'; ?>">
                <?php echo htmlspecialchars($notificacion['message'], ENT_QUOTES, 'UTF-8'); ?>
                <a href="index.php?controller=notificacion&action=markAsRead&id=<?php echo $notificacion['id']; ?>" class="btn btn-primary btn-sm float-end">Marcar como leída</a>
            </li>
        <?php endforeach; ?>
        <?php if (empty($notificaciones)): ?>
            <li class="list-group-item">No hay notificaciones</li>
        <?php endif; ?>
    </ul>
</div>
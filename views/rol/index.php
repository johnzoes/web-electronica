<div class="container">
    <h2 class="my-4 poppins-bold">Lista de Roles</h2>
    <a href="index.php?controller=rol&action=create" class="btn btn-success mb-3">Crear Rol</a>
    <table class="table-modern">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($roles as $rol): ?>
            <tr>
                <td><?php echo htmlspecialchars($rol['id_rol'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($rol['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <a href="index.php?controller=rol&action=edit&id=<?php echo htmlspecialchars($rol['id_rol'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary btn-sm">Editar</a>
                    <form action="index.php?controller=rol&action=delete&id=<?php echo htmlspecialchars($rol['id_rol'], ENT_QUOTES, 'UTF-8'); ?>" method="POST" style="display: inline-block;">
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

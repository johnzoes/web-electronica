<div class="container">
    <h2>Lista de Roles</h2>
    <a href="index.php?controller=rol&action=create" class="btn btn-success mb-3">Crear Rol</a>
    <table class="table">
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
                <td><?php echo $rol['id_rol']; ?></td>
                <td><?php echo $rol['nombre']; ?></td>
                <td>
                    <a href="index.php?controller=rol&action=edit&id=<?php echo $rol['id_rol']; ?>" class="btn btn-primary">Editar</a>
                    <form action="index.php?controller=rol&action=delete&id=<?php echo $rol['id_rol']; ?>" method="POST" style="display: inline-block;">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

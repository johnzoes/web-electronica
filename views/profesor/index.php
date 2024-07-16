<div class="container mt-5">
    <h2 class="mb-4">Lista de Profesores</h2>
    <table class="table">
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
                    <td><?php echo $profesor['nombre_usuario']; ?></td>
                    <td><?php echo $profesor['nombre']; ?></td>
                    <td><?php echo $profesor['apellidos']; ?></td>
                    <td>
                        <a href="index.php?controller=profesor&action=edit&id=<?php echo $profesor['id_usuario']; ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="index.php?controller=profesor&action=delete&id=<?php echo $profesor['id_usuario']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>



<div class="container-main">
    <h2 class="my-4 poppins-bold">Lista de Asistentes</h2>
    <table class="table-modern">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Turno</th>
                <th>Salón</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datos_asistente as $asistente): ?>
                <tr>
                    <td><?php echo htmlspecialchars($asistente['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($asistente['nombre_usuario'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($asistente['nombre_turno'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($asistente['id_salon'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <a href="index.php?controller=asistente&action=edit&id=<?php echo htmlspecialchars($asistente['id_usuario'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-warning btn-sm">
                            <!-- SVG para Editar -->
                        </a>
                        <a href="index.php?controller=asistente&action=delete&id=<?php echo htmlspecialchars($asistente['id_usuario'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">
                            <!-- SVG para Eliminar -->
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($datos_asistente)): ?>
                <tr>
                    <td colspan="5">No hay asistentes disponibles</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

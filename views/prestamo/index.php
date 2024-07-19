<div class="container">
    <h2 class="my-4 poppins-bold">Lista de Préstamos</h2>
    <a href="index.php?controller=prestamo&action=create" class="btn btn-primary mb-3">Realizar Préstamos</a>
    
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>ID Préstamo</th>
                    <th>ID Reserva</th>
                    <th>Hora</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($prestamos as $prestamo): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($prestamo['id_prestamo'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($prestamo['id_reserva'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($prestamo['hora'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($prestamo['fecha'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <a href="index.php?controller=prestamo&action=edit&id=<?php echo htmlspecialchars($prestamo['id_prestamo'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-warning btn-sm">
                                <!-- SVG para Editar -->
                            </a>
                            <a href="index.php?controller=prestamo&action=delete&id=<?php echo htmlspecialchars($prestamo['id_prestamo'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">
                                <!-- SVG para Eliminar -->
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="container mt-5">
    <h2 class="mb-4">Lista de Préstamos</h2>
    <a href="index.php?controller=prestamo&action=create" class="btn btn-primary mb-3">Realizar Préstamos</a>
    
    <div class="table-responsive">
        <table class="table table-striped">
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
                        <td><?php echo $prestamo['id_prestamo']; ?></td>
                        <td><?php echo $prestamo['id_reserva']; ?></td>
                        <td><?php echo $prestamo['hora']; ?></td>
                        <td><?php echo $prestamo['fecha']; ?></td>
                        <td>
                            <a href="index.php?controller=prestamo&action=edit&id=<?php echo $prestamo['id_prestamo']; ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="index.php?controller=prestamo&action=delete&id=<?php echo $prestamo['id_prestamo']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

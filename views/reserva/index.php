
<?php
require_once 'models/estado_reserva.php';
?>


<div class="container">
    <h2 class="poppins-bold">Lista de Reservas</h2>
    <a href="index.php?controller=reserva&action=create" class="btn btn-success mb-3">Crear Reserva</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha de Prestamo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservas as $reserva): ?>
                <?php 
                    $estado = EstadoReserva::getEstadoByReserva($reserva['id_reserva']);
                    ?>
            <tr>
                <td><?php echo $reserva['id_reserva']; ?></td>
                <td><?php echo $reserva['fecha_prestamo']; ?></td>
                <td><?php echo $estado['estado']; ?></td>

                <td>
                    <a href="index.php?controller=reserva&action=edit&id=<?php echo $reserva['id_reserva']; ?>" class="btn btn-primary">Editar</a>
                    <form action="index.php?controller=reserva&action=delete&id=<?php echo $reserva['id_reserva']; ?>" method="POST" style="display: inline-block;">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

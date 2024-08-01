<?php
require_once 'models/estado_reserva.php';
?>

<div class="button-container">
    <button id="btnTable1">Reservas Pendientes</button>
    <button id="btnTable2">Historial Reservas</button>
    <button id="btnTable3">Reservas Rechazadas</button>

</div>

<div id="reservasPendientesContainer" class="table-container">
    <h2 class="my-4 poppins-bold">Lista de Reservas Pendientes</h2>
    <table id="table_reservas_pendientes" class="table-modern">
        <thead>
            <tr>
                <th>ID Reserva</th>
                <th>Fecha Prestamo</th>
                <th>Unidad Didactica</th>
                <th>Turno</th>
                <th>Profesor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $hasVisibleReservations = false; // Variable para controlar si hay reservas visibles

            foreach ($reservas_pendientes as $reserva):
                $estadoReserva = EstadoReserva::getEstadoByReserva($reserva['id_reserva']);
                if ($estadoReserva['estado'] == 'Rechazado' || $estadoReserva['estado'] == 'Devuelto') {
                    continue; // Omite esta reserva si está rechazada o devuelta
                }
                $hasVisibleReservations = true; // Marca que hay reservas visibles
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($reserva['id_reserva'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($reserva['fecha_prestamo'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($reserva['nombre_unidad_didactica'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($reserva['nombre_turno'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($reserva['nombre_profesor'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <?php if ($estadoReserva['estado'] == 'Pendiente'): ?>
                            <a href="index.php?controller=asistente&action=actualizar_estado_reserva&id_reserva=<?php echo htmlspecialchars($reserva['id_reserva'], ENT_QUOTES, 'UTF-8'); ?>&nuevo_estado=aprobado" class="btn btn-success btn-sm">Aceptar</a>
                            <a href="index.php?controller=asistente&action=actualizar_estado_reserva&id_reserva=<?php echo htmlspecialchars($reserva['id_reserva'], ENT_QUOTES, 'UTF-8'); ?>&nuevo_estado=rechazado" class="btn btn-danger btn-sm">Rechazar</a>
                        <?php elseif ($estadoReserva['estado'] == 'Aprobado'): ?>
                            <a href="index.php?controller=asistente&action=actualizar_estado_reserva&id_reserva=<?php echo htmlspecialchars($reserva['id_reserva'], ENT_QUOTES, 'UTF-8'); ?>&nuevo_estado=prestado" class="btn btn-primary btn-sm">Se prestó</a>
                        <?php elseif ($estadoReserva['estado'] == 'Prestado'): ?>
                            <a href="index.php?controller=asistente&action=actualizar_estado_reserva&id_reserva=<?php echo htmlspecialchars($reserva['id_reserva'], ENT_QUOTES, 'UTF-8'); ?>&nuevo_estado=devuelto" class="btn btn-primary btn-sm">Devuelto</a>
                        <?php elseif ($estadoReserva['estado'] == 'Devuelto'): ?>
                            <span class="badge bg-success">Finalizado</span>
                        <?php elseif ($estadoReserva['estado'] == 'Rechazado'): ?>
                            <span class="badge bg-danger">Rechazado</span>
                        <?php endif; ?> 
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$hasVisibleReservations): ?>
                <tr>
                    <td colspan="6">No hay reservas pendientes</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>


<div id="historialReservasContainer" class="table-container" style="display: none;">
    <h2 class="my-4 poppins-bold">Historial de Reservas</h2>
    <table id="table_historial_reservas" class="table-modern">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha de Préstamo</th>
                <th>Unidad Didáctica</th>
                <th>Turno</th>
                <th>Profesor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $showNoDataMessage = true; // Variable para controlar si mostrar el mensaje de "No hay datos"

            foreach ($reservas as $reserva):
                $estadoReserva = EstadoReserva::getEstadoByReserva($reserva['id_reserva']);
                if ($estadoReserva['estado'] == 'Devuelto'): 
                    $showNoDataMessage = false; // Cambia a false si hay al menos una reserva aprobada
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($reserva['id_reserva'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($reserva['fecha_prestamo'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($reserva['nombre_unidad_didactica'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($reserva['nombre_turno'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($reserva['nombre_profesor'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="window.open('index.php?controller=reserva&action=showPDF&id=<?php echo $reserva['id_reserva']; ?>')">Ver Reserva</button>
                        <a href="index.php?controller=reserva&action=downloadPDF&id=<?php echo htmlspecialchars($reserva['id_reserva'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-secondary btn-sm">Descargar</a>
                    </td>
                </tr>
            <?php
                endif;
            endforeach;
            if ($showNoDataMessage): ?>
                <tr>
                    <td colspan="6">No hay reservas aprobadas</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>



<div id="reservasRechazadasContainer" class="table-container" style="display: none;">
    <h2 class="my-4 poppins-bold">Reservas Rechazadas</h2>
    <table id="table_reservas_rechazadas" class="table-modern">
        <thead>
            <tr>
                <th>ID Reserva</th>
                <th>Fecha Prestamo</th>
                <th>Unidad Didactica</th>
                <th>Turno</th>
                <th>Profesor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $showNoDataMessage = true; // Variable para controlar si mostrar el mensaje de "No hay datos"

            foreach ($reservas as $reserva):
                $estadoReserva = EstadoReserva::getEstadoByReserva($reserva['id_reserva']);
                if ($estadoReserva['estado'] == 'Rechazado'): 
                    $showNoDataMessage = false; // Cambia a false si hay al menos una reserva rechazada
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($reserva['id_reserva'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($reserva['fecha_prestamo'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($reserva['nombre_unidad_didactica'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($reserva['nombre_turno'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($reserva['nombre_profesor'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <span class="badge bg-danger">Rechazado</span>
                    </td>
                </tr>
            <?php
                endif;
            endforeach;
            if ($showNoDataMessage): ?>
                <tr>
                    <td colspan="6">No hay reservas rechazadas</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnTable1 = document.getElementById('btnTable1');
    const btnTable2 = document.getElementById('btnTable2');
    const btnTable3 = document.getElementById('btnTable3');
    const reservasPendientesContainer = document.getElementById('reservasPendientesContainer');
    const historialReservasContainer = document.getElementById('historialReservasContainer');
    const reservasRechazadasContainer = document.getElementById('reservasRechazadasContainer');

    btnTable1.addEventListener('click', function() {
        reservasPendientesContainer.style.display = 'block';
        historialReservasContainer.style.display = 'none';
        reservasRechazadasContainer.style.display = 'none';
    });

    btnTable2.addEventListener('click', function() {
        reservasPendientesContainer.style.display = 'none';
        historialReservasContainer.style.display = 'block';
        reservasRechazadasContainer.style.display = 'none';
    });

    btnTable3.addEventListener('click', function() {
        reservasPendientesContainer.style.display = 'none';
        historialReservasContainer.style.display = 'none';
        reservasRechazadasContainer.style.display = 'block';
    });
});

</script>

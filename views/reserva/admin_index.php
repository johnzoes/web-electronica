<?php
require_once 'models/estado_reserva.php';
?>
<link rel="stylesheet" href="views/reserva/reserva.css">

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
           
        

        </tbody>
    </table>
</div>

<div id="modal-container"></div>

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

    function loadReservas(type, tableBodyId) {
        fetch('views/reserva/get_reservas.php?type=' + type)

            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector(`#${tableBodyId} tbody`);
                tbody.innerHTML = '';  // Limpiar la tabla antes de cargar los nuevos datos

                data.forEach(reserva => {
                    const row = `
                        <tr>
                            <td>${reserva.id_reserva}</td>
                            <td>${reserva.fecha_prestamo}</td>
                            <td>${reserva.unidad_didactica}</td>
                            <td>${reserva.turno}</td>
                            <td>${reserva.profesor}</td>
                            <td>
                                <button class="ver-detalles" data-reserva='${JSON.stringify(reserva)}'>Ver Detalles</button>
                            </td>
                        </tr>`;
                    tbody.insertAdjacentHTML('beforeend', row);
                });
            })
            .catch(error => console.error('Error al cargar las reservas:', error));
    }

    btnTable1.addEventListener('click', function() {
        reservasPendientesContainer.style.display = 'block';
        historialReservasContainer.style.display = 'none';
        reservasRechazadasContainer.style.display = 'none';
        loadReservas('pendientes', 'table_reservas_pendientes');
    });

    btnTable2.addEventListener('click', function() {
        reservasPendientesContainer.style.display = 'none';
        historialReservasContainer.style.display = 'block';
        reservasRechazadasContainer.style.display = 'none';
        loadReservas('historial', 'table_historial_reservas');
    });

    btnTable3.addEventListener('click', function() {
        reservasPendientesContainer.style.display = 'none';
        historialReservasContainer.style.display = 'none';
        reservasRechazadasContainer.style.display = 'block';
        loadReservas('rechazadas', 'table_reservas_rechazadas');
    });

    // Cargar inicialmente las reservas pendientes al cargar la página
    loadReservas('pendientes', 'table_reservas_pendientes');

    // Ver detalles de una reserva
    document.querySelectorAll('.ver-detalles').forEach(button => {
        button.addEventListener('click', function () {
            const reserva = JSON.parse(this.getAttribute('data-reserva'));
            const idReserva = reserva.id_reserva;

            fetch('views/reserva/modal_detalle_reserva.php?id_reserva=' + idReserva)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('modal-container').innerHTML = html;

                    const modalElement = document.getElementById('detalleReservaModal');
                    const modalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);
                    modalInstance.show();
                })
                .catch(error => {
                    console.error('Error fetching modal content:', error);
                });
        });
    });
});
</script>

<div class="container">
    <h2 class="my-4 poppins-bold">Reservas</h2>
    <table class="table-modern">
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
            <?php foreach ($reservas as $reserva): ?>
            <tr>
                <td><?php echo htmlspecialchars($reserva['id_reserva'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($reserva['fecha_prestamo'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($reserva['nombre_unidad_didactica'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($reserva['nombre_turno'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($reserva['nombre_profesor'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="showPDFModal(<?php echo $reserva['id_reserva']; ?>)">Ver Reserva</button>
                    <a href="index.php?controller=reserva&action=downloadPDF&id=<?php echo htmlspecialchars($reserva['id_reserva'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-secondary btn-sm">Descargar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfModalLabel">Ver Reserva</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe id="pdfFrame" src="" width="100%" height="500px"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
function showPDFModal(reservaId) {
    var pdfFrame = document.getElementById('pdfFrame');
    pdfFrame.src = 'index.php?controller=reserva&action=showPDF&id=' + reservaId;
    $('#pdfModal').modal('show');
}
</script>
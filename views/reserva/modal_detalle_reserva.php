<?php
require_once '../../models/estado_reserva.php';
require_once '../../models/item.php';

// Obtener el ID de la reserva desde la URL
$id_reserva = $_GET['id_reserva'];

// Obtener los ítems asociados a la reserva
$items = Item::getItemsByIdReserva($id_reserva);
?>

<!-- modal_detalle_reserva.php -->
<div class="modal fade" id="detalleReservaModal" tabindex="-1" aria-labelledby="detalleReservaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detalleReservaModalLabel">Detalles de la Reserva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>ID Reserva:</strong> <?php echo htmlspecialchars($id_reserva, ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Fecha Prestamo:</strong> <span id="detalle-fecha-prestamo"></span></p>
                <p><strong>Unidad Didactica:</strong> <span id="detalle-unidad-didactica"></span></p>
                <p><strong>Turno:</strong> <span id="detalle-turno"></span></p>
                <p><strong>Profesor:</strong> <span id="detalle-profesor"></span></p>
                
                <!-- Mostrar los ítems de la reserva en una lista -->
                <h5 class="mt-3">Ítems de la Reserva</h5>
                <ul>
                    <?php if (!empty($items)): ?>
                        <?php foreach ($items as $item): ?>
                            <li>
                                <strong>ID Item:</strong> <?php echo htmlspecialchars($item['id_item'], ENT_QUOTES, 'UTF-8'); ?> - 
                                <strong>Descripción:</strong> <?php echo htmlspecialchars($item['descripcion'], ENT_QUOTES, 'UTF-8'); ?>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>No hay ítems disponibles para esta reserva.</li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <h2>Crear Detalle de Reserva de Item</h2>
    <form action="index.php?controller=detalle_reserva_item&action=store" method="POST">
        <div class="form-group">
            <label for="id_reserva">ID de Reserva:</label>
            <input type="text" class="form-control" id="id_reserva" name="id_reserva" required>
        </div>
        <div class="form-group">
            <label for="id_item">ID del Item:</label>
            <input type="text" class="form-control" id="id_item" name="id_item" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear Detalle</button>
    </form>
</div>


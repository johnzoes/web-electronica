<div class="container">
    <h2>Actualizar Reserva</h2>
    <form action="index.php?controller=reserva&action=update&id=<?php echo $reserva['id_reserva']; ?>" method="POST">
        <div class="form-group">
            <label for="fecha_reserva">Fecha de Reserva:</label>
            <input type="date" class="form-control" id="fecha_reserva" name="fecha_reserva" value="<?php echo $reserva['fecha_reserva']; ?>" required>
        </div>
        <div class="form-group">
            <label for="fecha_prestamo">Fecha de Préstamo:</label>
            <input type="date" class="form-control" id="fecha_prestamo" name="fecha_prestamo" value="<?php echo $reserva['fecha_prestamo']; ?>" required>
        </div>
        <div class="form-group">
            <label for="hora_reserva">Hora de Reserva:</label>
            <input type="time" class="form-control" id="hora_reserva" name="hora_reserva" value="<?php echo $reserva['hora_reserva']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Reserva</button>
    </form>
</div>

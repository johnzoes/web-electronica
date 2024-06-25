<!-- PARA CREAR EL PRESTAMO SE HARA A TRAVES DEL BOTON EN EL INDEX DE RESERVAS, ASI CONFIRMAMOS EL PRESTAMO -->

<div class="container">
    <h2>Crear Préstamo</h2>
    <form action="index.php?controller=prestamo&action=store" method="POST">
        <div class="form-group">
            <label for="id_reserva">ID de Reserva:</label>
            <input type="text" class="form-control" id="id_reserva" name="id_reserva" required>
        </div>
        <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" class="form-control" id="fecha" name="fecha" required>
        </div>
        <div class="form-group">
            <label for="hora">Hora:</label>
            <input type="time" class="form-control" id="hora" name="hora" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear Préstamo</button>
    </form>
</div>

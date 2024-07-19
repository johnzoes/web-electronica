<div class="container">
    <h2 class="my-4 poppins-bold">Reservas</h2>
    <?php if ($_SESSION['role'] == 3): // Solo mostrar para profesores ?>
        <a href="index.php?controller=reserva&action=create" class="btn btn-success mb-3">Crear Reserva</a>
        <a href="index.php?controller=reserva&action=mis_reservas" class="btn btn-primary mb-3">Mis Reservas</a>
    <?php endif; ?>
</div>
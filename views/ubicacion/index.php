<?php
require_once 'models/salon.php';
?>

<div class="container">
    <h2>Lista de Ubicaciones</h2>
    <a href="index.php?controller=ubicacion&action=create" class="btn btn-success mb-3">Crear Ubicación</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre del Armario</th>
                <th>Salón</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ubicaciones as $ubicacion): ?>
                <tr>
                    <td><?php echo htmlspecialchars($ubicacion['nombre_armario'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($ubicacion['id_salon'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <a href="index.php?controller=ubicacion&action=edit&id=<?php echo htmlspecialchars($ubicacion['id_ubicacion'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary">Editar</a>
                        <form action="index.php?controller=ubicacion&action=delete&id=<?php echo htmlspecialchars($ubicacion['id_ubicacion'], ENT_QUOTES, 'UTF-8'); ?>" method="POST" style="display: inline-block;">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if (isset($_GET['message'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?php echo htmlspecialchars($_GET['message'], ENT_QUOTES, 'UTF-8'); ?>'
            });
        });
    </script>
<?php elseif (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Ubicación eliminada correctamente'
            });
        });
    </script>
<?php endif; ?>
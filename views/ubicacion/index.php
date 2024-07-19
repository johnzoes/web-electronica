<?php
require_once 'models/salon.php';
?>
<link rel="stylesheet" href="styles.css">

<div class="container">
    <h2 class="my-4 poppins-bold">Lista de Ubicaciones</h2>
    <a href="index.php?controller=ubicacion&action=create" class="btn btn-success mb-3">Crear Ubicación</a>
    <table class="table-modern" id="sortableTable">
        <thead>
            <tr>
                <th data-sort="name">Nombre del Armario</th>
                <th data-sort="salon">Salón</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ubicaciones as $ubicacion): ?>
                <tr>
                    <td><?php echo htmlspecialchars($ubicacion['nombre_armario'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($ubicacion['id_salon'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                    <a href="index.php?controller=ubicacion&action=edit&id=<?php echo htmlspecialchars($ubicacion['id_ubicacion'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary btn-sm">
                            <img src="images/icons8-editar.svg" alt="Editar" width="25" height="25">
                        </a>                  
                    <button type="submit" class="btn">
                                <img src="images/icons8-eliminar.svg" alt="Eliminar" width="25" height="25">
                            </button>
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

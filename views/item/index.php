<?php
require_once 'models/database.php';
require_once 'models/userRole.php';
require_once 'models/permisos.php';
require_once 'middleware/AuthorizationMiddleware.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?controller=auth&action=login');
    exit;
}

$userId = $_SESSION['user_id'];
$role = $_SESSION['role'];
$db = connectDatabase();

?>
<link rel="stylesheet" href="views/item/item.css">
<div class="container">
    <h2 class="my-4 poppins-bold">Lista de Items</h2>
    <?php if ($role !== 3): // El rol 3 es para Profesor ?>
        <a href="index.php?controller=item&action=create&id_categoria=<?php echo htmlspecialchars($id_categoria, ENT_QUOTES, 'UTF-8'); ?>"
            class="btn btn-success mb-3">Crear Item</a>
    <?php endif; ?>
    <div class="center-table">
    <table class="table-modern">
        <thead>
            <tr>
                <th>Código BCI</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Estado</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Imagen</th>
                <th>Ubicación</th>
                <th>Nro. Inventariado</th>
                <th>Categoría</th>
                <?php if ($role !== 3): // El rol 3 es para Profesor ?>
                    <th>Acciones</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if ($items): ?>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['codigo_bci'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($item['descripcion'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($item['cantidad'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($item['estado'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($item['marca'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($item['modelo'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <?php if (!empty($item['imagen'])): ?>
                                <img src="images/<?php echo htmlspecialchars($item['imagen'], ENT_QUOTES, 'UTF-8'); ?>" alt="Imagen"
                                    width="50">
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($item['id_ubicacion'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($item['nro_inventariado'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($item['id_categoria'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <?php if ($role !== 3): // El rol 3 es para Profesor ?>
                            <td>
                                <a href="index.php?controller=item&action=edit&id=<?php echo htmlspecialchars($item['id_item'], ENT_QUOTES, 'UTF-8'); ?>"
                                    class="btn btn-primary btn-sm">
                                    <!-- SVG para Editar -->
                                </a>
                                <form action="index.php?controller=item&action=delete&id=<?php echo htmlspecialchars($item['id_item'], ENT_QUOTES, 'UTF-8'); ?>"
                                    method="POST" style="display: inline-block;">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <!-- SVG para Eliminar -->
                                    </button>
                                </form>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="<?php echo $role !== 3 ? '11' : '10'; ?>">No hay items disponibles</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>

<?php if (isset($_GET['message'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?php echo htmlspecialchars($_GET['message'], ENT_QUOTES, 'UTF-8'); ?>'
            });
        });
    </script>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteForms = document.querySelectorAll('form[action*="delete"]');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                const url = form.getAttribute('action');

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminarlo!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(url, {
                            method: 'POST'
                        })
                        .then(response => {
                            if (response.ok) {
                                form.closest('tr').remove();
                                Swal.fire(
                                    'Eliminado!',
                                    'El ítem ha sido eliminado.',
                                    'success'
                                );
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'Hubo un problema al eliminar el ítem.',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            Swal.fire(
                                'Error!',
                                'Hubo un problema al eliminar el ítem.',
                                'error'
                            );
                        });
                    }
                });
            });
        });
    });
</script>

<?php
require_once 'models/database.php';
require_once 'models/userRole.php';
require_once 'models/permisos.php';
require_once 'middleware/AuthorizationMiddleware.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?controller=auth&action=login');
    exit;
}

$userId = $_SESSION['user_id'];
$db = connectDatabase();
$userRole = new UserRole($db);
$roleId = $userRole->getRoleIdByUserId($userId);
$authorizationMiddleware = new AuthorizationMiddleware(new UserRole($db), new Permission($db));
$canCreateItem = ($roleId == 1 || $roleId == 2);
?>

<div class="container">
    <h2>Lista de Items</h2>
    <?php if ($canCreateItem): ?>
        <a href="index.php?controller=item&action=create&id_categoria=<?php echo $id_categoria; ?>"
            class="btn btn-success mb-3">Crear Item</a>
    <?php endif; ?>
    <table class="table">
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
                <th>Acciones</th>
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
                        <td>
                            <a href="index.php?controller=item&action=edit&id=<?php echo htmlspecialchars($item['id_item'], ENT_QUOTES, 'UTF-8'); ?>"
                                class="btn btn-primary">Editar</a>
                            <form
                                action="index.php?controller=item&action=delete&id=<?php echo htmlspecialchars($item['id_item'], ENT_QUOTES, 'UTF-8'); ?>"
                                method="POST" style="display: inline-block;">
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="11">No hay items disponibles</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
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
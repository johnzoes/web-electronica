<?php
require_once 'config/database.php';
require_once 'models/Permission.php';
require_once 'models/UserRole.php';
require_once 'middleware/AuthorizationMiddleware.php';
require_once 'controllers/categoriaController.php';
require_once 'controllers/profesorController.php';
require_once 'controllers/detalleReservaItemController.php';
require_once 'controllers/itemController.php';
require_once 'controllers/prestamoController.php';
require_once 'controllers/reservaController.php';
require_once 'controllers/rolController.php';
require_once 'controllers/salonController.php';
require_once 'controllers/ubicacionController.php';
require_once 'controllers/unidadDidacticaController.php';
require_once 'controllers/usuarioController.php';
require_once 'controllers/authController.php';
require_once 'controllers/asistenteController.php';

session_start();
$db = connectDatabase();
$permissionModel = new Permisos($db);
$userRoleModel = new UserRole($db);
$authorizationMiddleware = new AuthorizationMiddleware($userRoleModel, $permissionModel);

$controllerName = isset($_GET['controller']) ? htmlspecialchars($_GET['controller']) : 'categoria';
$actionName = isset($_GET['action']) ? htmlspecialchars($_GET['action']) : 'index';

$controllers = [
    'item' => 'ItemController',
    'profesor' => 'ProfesorController',
    'categoria' => 'CategoriaController',
    'prestamo' => 'PrestamoController',
    'reserva' => 'ReservaController',
    'ubicacion' => 'UbicacionController',
    'salon' => 'SalonController',
    'unidad_didactica' => 'UnidadDidacticaController',
    'usuario' => 'UsuarioController',
    'rol' => 'RolController',
    'detalle_reserva_item' => 'DetalleReservaItemController',
    'asistente' => 'AsistenteController',
    'auth' => 'AuthController'
];

$permissions = [
    'create' => 'create_item',
    'edit' => 'edit_item',
    'update' => 'edit_item',
    'delete' => 'delete_item',
    'index' => 'view_item',
    'show' => 'view_item'
];

if (array_key_exists($controllerName, $controllers)) {
    $controllerClass = $controllers[$controllerName];
    $controller = new $controllerClass($authorizationMiddleware); // Pass the middleware to the controller

    if (method_exists($controller, $actionName)) {
        $userId = $_SESSION['user_id'];
        $requiredPermission = $permissions[$actionName] ?? 'view_item';

        if ($authorizationMiddleware->checkPermission($userId, $requiredPermission)) {
            if (in_array($actionName, ['edit', 'update', 'delete'])) {
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $controller->$actionName($id);
                } else {
                    // Handle missing ID error
                    echo "Error: ID is required for this action.";
                }
            } else {
                $controller->$actionName();
            }
        } else {
            // Handle unauthorized access
            echo "Error: You do not have permission to perform this action.";
        }
    } else {
        // Handle invalid action
        echo "Error: Action '$actionName' not found in controller '$controllerClass'.";
    }
} else {
    // Handle invalid controller
    echo "Error: Controller '$controllerName' not found.";
}
?>

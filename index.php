<?php
require_once 'controllers/categoriaController.php';
require_once 'controllers/profesorController.php';
require_once 'controllers/detalleReservaItemController.php';
require_once 'controllers/itemController.php';
require_once 'controllers/prestamoController.php';
require_once 'controllers/reservaController.php';
require_once 'controllers/RolController.php';
require_once 'controllers/SalonController.php';
require_once 'controllers/UbicacionController.php';
require_once 'controllers/UnidadDidacticaController.php';
require_once 'controllers/UsuarioController.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/AsistenteController.php';

$controllerName = isset($_GET['controller']) ? htmlspecialchars($_GET['controller']) : 'categoria';
$actionName = isset($_GET['action']) ? htmlspecialchars($_GET['action']) : 'index';

$controllers = [
    'item' => 'ItemController',
    'profesor' => 'ProfesorController',
    'categoria' => 'CategoriaContrloller',
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

if (array_key_exists($controllerName, $controllers)) {
    $controllerClass = $controllers[$controllerName];
    $controller = new $controllerClass();

    if (method_exists($controller, $actionName)) {
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
        // Handle invalid action
        echo "Error: Action '$actionName' not found in controller '$controllerClass'.";
    }
} else {
    // Handle invalid controller
    echo "Error: Controller '$controllerName' not found.";
}

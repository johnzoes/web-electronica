<?php
session_start();

require_once 'controllers/categoriaController.php';
require_once 'controllers/notificacionController.php';
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
require_once 'controllers/notificacionController.php';
require_once 'middleware/AuthorizationMiddleware.php';
require_once 'models/usuario.php';
require_once 'models/permisos.php';
require_once 'models/userRole.php';
require_once 'models/database.php';
require_once 'models/notificacion.php';

$controllerName = isset($_GET['controller']) ? htmlspecialchars($_GET['controller']) : 'categoria';
$actionName = isset($_GET['action']) ? htmlspecialchars(string: $_GET['action']) : 'index';

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
    'auth' => 'AuthController',
    'notificacion' => 'NotificacionController'
];

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id']) && $controllerName !== 'auth') {
    header('Location: index.php?controller=auth&action=login');
    exit;
}

// Verificar si el usuario tiene permiso para acceder al controlador de usuarios
if ($controllerName == 'usuario' && (!isset($_SESSION['role']) || $_SESSION['role'] != 1)) {
    header('Location: index.php');
    exit;
}

try {
    // Conectar a la base de datos
    $db = connectDatabase();

    // Crear instancias de las clases necesarias
    $userRole = new UserRole($db);
    $permission = new Permission($db);

    // Crear una instancia de AuthorizationMiddleware
    $authorizationMiddleware = new AuthorizationMiddleware($userRole, $permission);

    // Obtener las notificaciones para el usuario actual
    if (isset($_SESSION['user_id'])) {
        $notificaciones = Notification::getByUserId($_SESSION['user_id']);
        $notificaciones_no_leidas = Notification::countUnreadByUser($_SESSION['user_id']);
    } else {
        $notificaciones = [];
        $notificaciones_no_leidas = 0;
    }

    // Instanciar el controlador con dependencias
    if (array_key_exists($controllerName, $controllers)) {
        $controllerClass = $controllers[$controllerName];
    
        if ($controllerClass === 'ItemController') {
            $controller = new $controllerClass($authorizationMiddleware);
        } else {
            $controller = new $controllerClass($db);
        }

        if (method_exists($controller, $actionName)) {
            if (in_array($actionName, haystack: ['edit', 'update', 'delete', 'showPDF', 'downloadPDF', 'view', 'actualizar_estado_reserva'])) {
                if (isset($_GET['id']) || isset($_GET['id_reserva'])) {
                    $id = isset($_GET['id']) ? $_GET['id'] : $_GET['id_reserva'];
                    $nuevo_estado = isset($_GET['nuevo_estado']) ? $_GET['nuevo_estado'] : '';
                    $controller->$actionName($id, $nuevo_estado);
                } else {
                    echo "Error: ID is required for this action.";
                }
            } else {
                $controller->$actionName();
            }
        } else {
            echo "Error: Action '$actionName' not found in controller '$controllerClass'.";
        }
    } else {
        echo "Error: Controller '$controllerName' not found.";
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

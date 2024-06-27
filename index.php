<?php
require_once 'controllers/CategoriaController.php';
require_once 'controllers/ProfesorController.php';
require_once 'controllers/DetalleReservaItemController.php';
require_once 'controllers/ItemController.php';
require_once 'controllers/PrestamoController.php';
require_once 'controllers/ReservaController.php';
require_once 'controllers/RolController.php';
require_once 'controllers/SalonController.php';
require_once 'controllers/UbicacionController.php';
require_once 'controllers/UnidadDidacticaController.php';
require_once 'controllers/UsuarioController.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/AsistenteController.php';


$controller = isset($_GET['controller']) ? $_GET['controller'] : 'categoria';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Crear instancia del controlador según el parámetro 'controller'
switch ($controller) {
    case 'item':
        $controller = new ItemController();
        break;
    case 'profesor':
        $controller = new ProfesorController();
        break;
    case 'curso':
        $controller = new CursoController();
        break;
    case 'categoria':
        $controller = new CategoriaController();
        break;
    case 'prestamo':
        $controller = new PrestamoController(); 
        break;
    case 'reserva':
        $controller = new ReservaController();
        break;
    case 'ubicacion':
        $controller = new UbicacionController();
        break;
    case 'salon':
        $controller = new SalonController();
        break;
    case 'unidad_didactica':
        $controller = new UnidadDidacticaController();
        break;
    case 'usuario':
        $controller = new UsuarioController();           
        break;
    case 'rol':
        $controller = new RolController();
        break;
    case 'detalle_reserva_item':
        $controller = new DetalleReservaItemController();
        break;
    case 'asistente':
        $controller = new asistenteController();
        break;

    case 'auth':
            $controller = new authController();
            break;




    default:
        // Controlador predeterminado en caso de que no se proporcione uno válido en la URL
}

// Ejecutar la acción correspondiente en el controlador
switch ($action) {
    case 'index':
        $controller->index();
        break;

    case 'edit':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $controller->edit($id);
        } else {
            // Manejar el caso en el que no se proporciona un ID
            // Aquí puedes redirigir a una página de error o hacer otra acción apropiada
        }
        break;

        case 'obtener_armario':
            if (method_exists($controller, 'obtener_armario')) {
                $controller->obtener_armario();
            }
            break;         

    case 'create':
        $controller->create();
        break;
        case 'create_two':
            $controller->create_two();
            break;

    case 'update':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $controller->update($id);
        } else {
            // Manejar el caso en el que no se proporciona un ID
            // Aquí puedes redirigir a una página de error o hacer otra acción apropiada
        }
        break;

    case 'store':
        $controller->store();
        break;
        
        case 'store_two':
            $controller->store_two();
            break;
    case 'authenticate':
            $controller->authenticate();
            break;

    case 'delete':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $controller->delete($id);

        } else {
            // Manejar el caso en el que no se proporciona un ID
            // Aquí puedes redirigir a una página de error o hacer otra acción apropiada
        }
        break;


        case 'login':

            $controller->login();
            break;

        case'obtener_unidad_didactica':
            if (method_exists($controller, 'obtener_unidad_didactica')) {
                $controller->obtener_unidad_didactica();
            }
            break;   
    default:

        // Manejar casos de acción no válidos
        // Aquí puedes redirigir a una página de error o hacer otra acción apropiada
}
?>  

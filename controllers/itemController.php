<?php

require_once 'models/item.php';
require_once 'models/ubicacion.php';
require_once 'middleware/AuthorizationMiddleware.php';

class ItemController
{

    private $authorizationMiddleware;

    public function __construct($authorizationMiddleware)
    {
        $this->authorizationMiddleware = $authorizationMiddleware;
    }

    public function todo()
    {
        // Obtener el parámetro de la categoría seleccionada
        $view = 'views/item/index.php';
        $items = Item::all();
        require_once 'views/layout.php';
    }

    public function index()
    {
        // Obtener el parámetro de la categoría seleccionada
        $id_categoria = isset($_GET['id_categoria']) ? $_GET['id_categoria'] : null;
        $items = Item::getItemsByCategoria($id_categoria);
        $view = 'views/item/index.php';
        require_once 'views/layout.php';
    }

    public function show($id)
    {
        $item = Item::find($id);
        $view = 'views/item/show.php';
        require_once 'views/layout.php';
    }

    public function create()
    {
        // Verificar permiso antes de mostrar el formulario
        $userId = $_SESSION['user_id'];
        if ($this->authorizationMiddleware->checkPermission($userId, 'create_item')) {
            $id_categoria = isset($_GET['id_categoria']) ? $_GET['id_categoria'] : null;
            $view = 'views/item/create.php';
            require_once 'views/layout.php';
        } else {
            $message = "No tienes permiso para crear un nuevo item.";
            echo "<script>window.location.href='index.php?controller=item&action=index&message=" . urlencode($message) . "'</script>";
        }
    }

    public function store()
    {
        // Verificar permiso antes de almacenar el nuevo item
        $userId = $_SESSION['user_id'];
            if (!$this->authorizationMiddleware->checkPermission($userId, 'create_item')) {
                throw new Exception("No tienes permiso para crear un nuevo item.");
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtener datos del formulario y crear el item
            $codigo_bci = $_POST['codigo_bci'];
            $descripcion = $_POST['descripcion'];
            $cantidad = $_POST['cantidad'];
            $estado = $_POST['estado'];
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $id_ubicacion = $_POST['id_armario'];
            $nro_inventariado = $_POST['nro_inventariado'];
            $id_categoria = $_POST['id_categoria'];
            $imagen = $_FILES['imagen']['name'];

            // Manejar la subida de la imagen
            $imagen = null;
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                $imagen = basename($_FILES['imagen']['name']);
                $target_path = "images/" . $imagen;

                // Mover la imagen subida al directorio de imágenes
                if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $target_path)) {
                    echo "Error al subir la imagen.";
                    return;
                }
            }

            $data = [
                'codigo_bci' => $codigo_bci,
                'descripcion' => $descripcion,
                'cantidad' => $cantidad,
                'estado' => $estado,
                'marca' => $marca,
                'modelo' => $modelo,
                'id_ubicacion' => $id_ubicacion,
                'nro_inventariado' => $nro_inventariado,
                'id_categoria' => $id_categoria,
                'imagen' => $imagen
            ];

            Item::create($data);
            header("Location: index.php?controller=item&action=index&id_categoria=" . $id_categoria);
            exit;
        }
    }

    public function edit($id)
    {
        // Verificar permiso antes de permitir la edición del item
        $userId = $_SESSION['user_id'];
        if (!$this->authorizationMiddleware->checkPermission($userId, 'edit_item')) {
            throw new Exception("No tienes permiso para editar este item.");
        }

        $item = Item::find($id);
        $salones = Salon::all();
        $view = 'views/item/edit.php';
        require_once 'views/layout.php';
    }

    public function update($id)
    {
        // Verificar permiso antes de actualizar el item
        $userId = $_SESSION['user_id'];
        if (!$this->authorizationMiddleware->checkPermission($userId, 'edit_item')) {
            throw new Exception("No tienes permiso para editar este item.");
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $codigo_bci = $_POST['codigo_bci'];
            $descripcion = $_POST['descripcion'];
            $cantidad = $_POST['cantidad'];
            $estado = $_POST['estado'];
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $id_ubicacion = $_POST['id_armario'];
            $nro_inventariado = $_POST['nro_inventariado'];
            $id_categoria = $_POST['id_categoria'];

            // Manejar la subida de la imagen
            $imagen = null;
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                $imagen = basename($_FILES['imagen']['name']);
                $target_path = "images/" . $imagen;

                // Mover la imagen subida al directorio de imágenes
                if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $target_path)) {
                    echo "Error al subir la imagen.";
                    return;
                }
            } else {
                $imagen = $_POST['imagen_actual']; // Mantener la imagen actual si no se sube una nueva
            }

            $data = [
                'codigo_bci' => $codigo_bci,
                'descripcion' => $descripcion,
                'cantidad' => $cantidad,
                'estado' => $estado,
                'marca' => $marca,
                'modelo' => $modelo,
                'id_ubicacion' => $id_ubicacion,
                'nro_inventariado' => $nro_inventariado,
                'id_categoria' => $id_categoria,
                'imagen' => $imagen
            ];

            Item::update($id, $data);
            header('Location: index.php?controller=item&action=index&id_categoria=' . $id_categoria);
            exit;
        }
    }

    public function delete($id)
    {
        // Verificar permiso antes de eliminar el item
        $userId = $_SESSION['user_id'];
        if (!$this->authorizationMiddleware->checkPermission($userId, 'delete_item')) {
            http_response_code(403);
            echo json_encode(["message" => "No tienes permiso para eliminar este item."]);
            exit;
        }

        if (Item::delete($id)) {
            http_response_code(200);
            echo json_encode(["message" => "Item eliminado exitosamente."]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Hubo un problema al eliminar el item."]);
        }
        exit;
    }

    public function obtener_armario()
    {
        if (isset($_GET['id_salon'])) {
            $id_salon = $_GET['id_salon'];
            $ubicaciones = Ubicacion::findBySalonId($id_salon);
            header('Content-Type: application/json');
            echo json_encode($ubicaciones);
        } else {
            header('Content-Type: application/json');
            echo json_encode([]);
        }
    }
}

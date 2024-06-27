<?php

require_once 'models/item.php';
require_once 'models/ubicacion.php';

class ItemController {


    public function todo() {
        // Obtener el parámetro de la categoría seleccionada
       
        $view = 'views/item/index.php';
           $items = Item::all();
           require_once 'views/layout.php';
       
       
       }
       


    public function index() {
 // Obtener el parámetro de la categoría seleccionada

 $id_categoria = isset($_GET['id_categoria']) ? $_GET['id_categoria'] : null;
 $view = 'views/item/index.php';
    $items = Item::getItemsByCategoria($id_categoria);
    require_once 'views/layout.php';


}


    public function show($id) {
        $item = Item::find($id);
        $view = 'views/item/show.php';
        require_once 'views/layout.php';    
    }


    public function create() {
        $id_categoria = isset($_GET['id_categoria']) ? $_GET['id_categoria'] : null;

        $view = 'views/item/create.php';
        require_once 'views/layout.php';
    }

    public function store() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $codigo_bci = $_POST['codigo_bci'];
            $descripcion = $_POST['descripcion'];
            $cantidad = $_POST['cantidad'];
            $estado = $_POST['estado'];
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            /* primero al seleccionar el id_salon filtramos ya por un salon, y cuando seleccionamos un armario 
            nos muestra solo los armarios d dicho salon, entonces al seleccionar un armario este armario ya tiene 
            la ubicacion en sí
            */
            $id_ubicacion = $_POST['id_armario'];
            $nro_inventariado = $_POST['nro_inventariado'];
            $id_categoria = $_POST['id_categoria'];
            $imagen = $_FILES['imagen']['name'];


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

    public function edit($id) {
        $item = Item::find($id);
        $salones = Salon::all();
        $view = 'views/item/edit.php';
        require_once 'views/layout.php';
    }

    public function update($id) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {


            $imagen = $_FILES['imagen']['name'];



            $data = [
                'codigo_bci' => $_POST['codigo_bci'],
                'descripcion' => $_POST['descripcion'],
                'cantidad' => $_POST['cantidad'],
                'estado' => $_POST['estado'],
                'marca' => $_POST['marca'],
                'modelo' => $_POST['modelo'],
                'imagen' => $imagen,
                'nro_inventariado' => $_POST['nro_inventariado'],

                /*el armario ya tiene la ubi */
                'id_ubicacion' => $_POST['id_armario'],
                'id_categoria' => $_POST['id_categoria']
            ];

            Item::update($id, $data);

            header('Location: index.php?controller=item&action=index');
            exit;
        }
    }

    public function delete($id) {
        Item::delete($id);
        header('Location: index.php?controller=item&action=index');
        exit;
    }

    public function obtener_armario() {
        header('Content-Type: application/json'); // Asegúrate de que la respuesta sea JSON
        if (isset($_GET['id_salon'])) {
            $id_salon = $_GET['id_salon'];
            $ubicaciones = Ubicacion::findBySalonId($id_salon);
            if ($ubicaciones !== false) {
                echo json_encode($ubicaciones);
            } else {
                echo json_encode([]);
            }
        } else {
            echo json_encode([]);
        }
    }


}


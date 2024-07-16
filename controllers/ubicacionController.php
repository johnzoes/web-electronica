<?php
require_once 'models/ubicacion.php';
require_once 'models/salon.php';
require_once 'models/item.php';

class UbicacionController {

    public function index() {
        $ubicaciones = Ubicacion::all();
        $view = 'views/ubicacion/index.php';
        require_once 'views/layout.php';
    }

    public function show($id) {
        $ubicacion = Ubicacion::find($id);
        $view = 'views/ubicacion/show.php';
        require_once 'views/layout.php';
    }

    public function create() {
        $salones = Salon::all();
        $view = 'views/ubicacion/create.php';
        require_once 'views/layout.php';
    }

    public function store() {

        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $data = [
                'id_salon' => $_POST['id_salon'],
                'nombre_armario' => $_POST['nombre_armario']
            ];
            
            Ubicacion::create($data);
            header('Location: index.php?controller=ubicacion&action=index');
            exit;
        }
    }

    public function edit($id) {
        $ubicacion = Ubicacion::find($id);
        if ($ubicacion) {
            $salones = Salon::all();
            $view = 'views/ubicacion/edit.php';
            require_once 'views/layout.php';
        } else {
            echo "Ubicación no encontrada.";
        }
    }

    public function update($id) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                'id_salon' => $_POST['id_salon'],
                'nombre_armario' => $_POST['nombre_armario']
            ];
            Ubicacion::update($id, $data);
            header('Location: index.php?controller=ubicacion&action=index');
            exit;
        }
    }

    public function delete($id) {
        $items = Item::findByUbicacion($id);
        if (!empty($items)) {
            $message = "No se puede eliminar la ubicación porque tiene items asociados.";
            echo "<script>window.location.href='index.php?controller=ubicacion&action=index&message=" . urlencode($message) . "'</script>";
        } else {
            Ubicacion::delete($id);
            echo "<script>window.location.href='index.php?controller=ubicacion&action=index&status=success'</script>";
        }
    }
}

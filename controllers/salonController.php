<?php
require_once 'models/salon.php';

class SalonController {

    public function index() {
        $salones = Salon::all();
        $view = 'views/salon/index.php';
        require_once 'views/layout.php';
    }

    public function show($id) {
        $salon = Salon::find($id);
        $view = 'views/salon/show.php';
        require_once 'views/layout.php';
    }

    public function create() {
        $view = 'views/salon/create.php';
        require_once 'views/layout.php';
    }

    public function store() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST['nombre_salon'])) {
                $error_nombre = 'Por favor, ingrese un nombre para el salón.';
            } else {
                $data = [
                    'nombre_salon' => $_POST['nombre_salon']
                ];
                Salon::create($data);
                header('Location: index.php?controller=salon&action=index');
                exit;
            }
        }
        // Resto del código para mostrar el formulario y los errores
    }
    

    public function edit($id) {
        $salon = Salon::find($id);
        $view = 'views/salon/edit.php';
        require_once 'views/layout.php';
    }

    public function update($id) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                'nombre_salon' => $_POST['nombre_salon']
            ];
            Salon::update($id, $data);
            header('Location: index.php?controller=salon&action=index');
            exit;
        }
    }

    public function delete($id) {
        Salon::delete($id);
        header('Location: index.php?controller=salon&action=index');
        exit;
    }
}
?>

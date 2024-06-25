<?php
require_once 'models/rol.php';

class RolController {

    public function index() {
        $roles = Rol::all();
        $view = 'views/rol/index.php';
        require_once 'views/layout.php';
    }

    public function show($id) {
        $rol = Rol::find($id);
        $view = 'views/rol/show.php';
        require_once 'views/layout.php';
    }

    public function create() {
        $view = 'views/rol/create.php';
        require_once 'views/layout.php';
    }

    public function store() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                'nombre' => $_POST['nombre']
            ];
            Rol::create($data);
            header('Location: index.php?controller=rol&action=index');
            exit;
        }
    }

    public function edit($id) {
        $rol = Rol::find($id);
        $view = 'views/rol/edit.php';
        require_once 'views/layout.php';
    }

    public function update($id) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                'nombre' => $_POST['nombre']
            ];
            Rol::update($id, $data);
            header('Location: index.php?controller=rol&action=index');
            exit;
        }
    }

    public function delete($id) {
        Rol::delete($id);
        header('Location: index.php?controller=rol&action=index');
        exit;
    }
}
?>

<?php
require_once 'models/categoria.php';

class CategoriaController {

    public function index() {
        $categorias = Categoria::all();
        $view = 'views/categoria/index.php';
        require_once 'views/layout.php';
    }

    public function show($id) {
        $categoria = Categoria::find($id);
        $view = 'views/categoria/show.php';
        require_once 'views/layout.php';
    }

    public function create() {
        $view = 'views/categoria/create.php';
        require_once 'views/layout.php';
    }

    public function store() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                'nombre_categoria' => $_POST['nombre_categoria']
            ];
            Categoria::create($data);
            header('Location: index.php?controller=categoria&action=index');
            exit;
        }
    }

    public function edit($id) {
        $categoria = Categoria::find($id);
        $view = 'views/categoria/edit.php';
        require_once 'views/layout.php';
    }

    public function update($id) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                'nombre_categoria' => $_POST['nombre_categoria']
            ];
            Categoria::update($id, $data);
            header('Location: index.php?controller=categoria&action=index');
            exit;
        }
    }

    public function delete($id) {
        Categoria::delete($id);
        header('Location: index.php?controller=categoria&action=index');
        exit;
    }
}
?>

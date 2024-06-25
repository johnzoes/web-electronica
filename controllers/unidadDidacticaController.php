<?php
require_once 'models/unidad_didactica.php';

class UnidadDidacticaController {

    public function index() {
        $unidadesDidacticas = UnidadDidactica::all();
        $view = 'views/unidad_didactica/index.php';
        require_once 'views/layout.php';
    }

    public function show($id) {
        $unidadDidactica = UnidadDidactica::find($id);
        $view = 'views/unidad_didactica/show.php';
        require_once 'views/layout.php';
    }

    public function create() {
        $view = 'views/unidad_didactica/create.php';
        require_once 'views/layout.php';
    }

    public function store() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                'nombre' => $_POST['nombre'],
                'ciclo' => $_POST['ciclo']
            ];
            UnidadDidactica::create($data);
            header('Location: index.php?controller=unidad_didactica&action=index');
            exit;
        }
    }

    public function edit($id) {
        $unidadDidactica = UnidadDidactica::find($id);
        $view = 'views/unidad_didactica/edit.php';
        require_once 'views/layout.php';
    }

    public function update($id) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                'nombre' => $_POST['nombre'],
                'ciclo' => $_POST['ciclo']
            ];
            UnidadDidactica::update($id, $data);
            header('Location: index.php?controller=unidad_didactica&action=index');
            exit;
        }
    }

    public function delete($id) {
        UnidadDidactica::delete($id);
        header('Location: index.php?controller=unidad_didactica&action=index');
        exit;
    }
}


?>

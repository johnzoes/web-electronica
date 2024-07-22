<?php
require_once 'models/profesor.php';
require_once 'models/usuario.php';
require_once 'models/notificacion.php';

class ProfesorController {

    public function index() {
        $profesores = Profesor::all();

        $datos_profesores = [];
        foreach ($profesores as $profesor){
            $usuario = Usuario::find($profesor['id_usuario']);
            if ($usuario){
                $datos_profesores[] = [
                    'id_usuario' => $usuario['id_usuario'],
                    'id_profesor' => $profesor['id_profesor'],
                    'nombre_usuario' => $usuario['nombre_usuario'],
                    'nombre' => $usuario['nombre'],
                    'apellidos' => $usuario['apellidos'],
                ];
            }
        }

        $notificaciones_no_leidas = Notification::countUnreadByUser($_SESSION['user_id']);
        $notificaciones = Notification::getByUserId($_SESSION['user_id']);

        $view = 'views/profesor/index.php';
        require_once 'views/layout.php';
    }

    public function show($id) {
        $profesor = Profesor::find($id);
        $view = 'views/profesor/show.php';
        require_once 'views/layout.php';
    }

    public function create() {
        $view = 'views/profesor/create.php';
        require_once 'views/layout.php';
    }

    public function store() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                'nombre' => $_POST['nombre']
            ];
            Profesor::create($data);
            header('Location: index.php?controller=profesor&action=index');
            exit;
        }
    }

    public function edit($id) {
        $usuario = Usuario::find($id);
        $view = 'views/profesor/edit.php';
        require_once 'views/layout.php';
    }

    public function update($id) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                'nombre_usuario' => $_POST['nombre_usuario'],
                'nombre' => $_POST['nombre'],
                'apellidos' => $_POST['apellidos']
            ];
            Usuario::update($id, $data);
            header('Location: index.php?controller=profesor&action=index');
            exit;
        }
    }

    public function delete($id) {
        Profesor::delete($id);
        header('Location: index.php?controller=profesor&action=index');
        exit;
    }
}
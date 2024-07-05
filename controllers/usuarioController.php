<?php
require_once 'models/usuario.php';
require_once 'models/profesor.php';
require_once 'models/asistente.php';
require_once 'models/rol.php';

require_once 'models/turno.php';
require_once 'models/salon.php';

class UsuarioController
{

    public function index()
    {
        $usuarios = Usuario::all();

        $datos_usuarios = [];

        foreach ($usuarios as $usuario) {
            if ($usuario) {

                $rol = Rol::find($usuario['id_rol']);

                $datos_usuarios[] = [
                    'id_usuario' => $usuario['id_usuario'],
                    'nombre_usuario' => $usuario['nombre_usuario'],
                    'nombre' => $usuario['nombre'],
                    'apellidos' => $usuario['apellidos'],
                    'rol' => $rol['nombre'],
                ];
            } else {

            }

        }


        $view = 'views/usuario/index.php';
        require_once 'views/layout.php';
    }

    public function show($id)
    {
        $usuario = Usuario::find($id);
        $view = 'views/usuario/show.php';
        require_once 'views/layout.php';
    }

    public function create()
    {
        $view = 'views/usuario/create.php';
        require_once 'views/layout.php';
    }

    public function create_two()
    {
        session_start();
        if (!isset($_SESSION['id_rol'])) {
            // Si no hay rol en la sesión, redirigir a la página de creación inicial
            header('Location: index.php?controller=usuario&action=create');
            exit();
        }

        $salones = Salon::all();
        $turnos = Turno::all();
        $view = 'views/usuario/create-two.php';
        require_once 'views/layout.php';
    }

    public function store()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Guardar el rol en la sesión
            $_SESSION['id_rol'] = $_POST['id_rol'];

            // Redirigir al siguiente formulario
            header('Location: index.php?controller=usuario&action=create_two');
            exit(); // Importante salir después de la redirección
        }
    }

    public function store_two()
    {
        session_start();

        // Verificar si hay un rol en la sesión
        if (!isset($_SESSION['id_rol'])) {
            // Si no hay rol en la sesión, redirigir a la página de creación inicial
            header('Location: index.php?controller=usuario&action=create');
            exit();
        }

        // Verificar si se está enviando un formulario POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Procesar datos del formulario de create-two.php
            $nombre_usuario = $_POST['nombre_usuario'];
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $password = $_POST['password'];
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $id_rol = $_SESSION['id_rol'];

            // Preparar los datos comunes para la creación de usuario
            $data = [
                'nombre_usuario' => $nombre_usuario,
                'nombre' => $nombre,
                'apellidos' => $apellidos,
                'password' => $hashed_password,
                'id_rol' => $id_rol
            ];

            // Crear el usuario y obtener el id generado
            $lastInsertId = Usuario::create($data);

            // Determinar qué tipo de usuario se está creando
            if ($_SESSION['id_rol'] == '2') {

                $turno = $_POST['turno'];
                $salon = $_POST['salon'];

                $asistente_data = [
                    'id_usuario' => $lastInsertId,
                    'id_turno' => $turno,
                    'id_salon' => $salon
                ];

                Asistente::create($asistente_data);
            } else {

                // Si el rol no es '2', se asume que es un Profesor
                $profesor_data = [
                    'id_usuario' => $lastInsertId
                ];

                Profesor::create($profesor_data);
            }

            // Limpiar los datos de la sesión después de la creación
            session_unset();
            session_destroy();

            // Redirigir al usuario a la página de lista de usuarios
            header('Location: index.php?controller=usuario&action=index');
            exit;
        }
    }


    public function edit($id)
    {
        $usuario = Usuario::find($id);
        $view = 'views/usuario/edit.php';
        require_once 'views/layout.php';
    }

    public function update($id)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                'nombre_usuario' => $_POST['nombre_usuario'],
                'password' => $_POST['password'],
                'id_rol' => $_POST['id_rol']
            ];
            Usuario::update($id, $data);
            header('Location: index.php?controller=usuario&action=index');
            exit;
        }
    }

    public function delete($id)
    {
        Usuario::delete($id);
        header('Location: index.php?controller=usuario&action=index');
        exit;
    }
}
?>
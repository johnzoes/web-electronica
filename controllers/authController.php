<?php
require_once 'models/usuario.php';

class AuthController {

    public function login() {
        require_once 'views/login.php';
    }

    public function authenticate() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre_usuario = $_POST['nombre_usuario'];
            $password = $_POST['password'];

            // Buscar el usuario por nombre de usuario
            $user = Usuario::findByUsername($nombre_usuario);

            // Verificar si el usuario existe y la contraseña es correcta
            if ($user && $this->verifyPassword($user, $password)) {
                $this->startUserSession($user);
                $this->redirectUserByRole($user['id_rol']);
            } else {
                // Usuario o contraseña incorrectos
                $this->showLoginError("Invalid username or password");
            }
        }
    }

    public function logout() {
        session_start();
        session_unset(); // Eliminar todas las variables de sesión
        session_destroy(); // Destruir la sesión
        header('Location: index.php?controller=auth&action=login');
        exit;
    }

    private function verifyPassword($user, $password) {
        // Verificar la contraseña para el administrador sin hashing
        if ($user['id_rol'] == 1) { // Administrador
            return $user['password'] == $password;
        } else { // Otros usuarios
            return password_verify($password, $user['password']);
        }
    }

    private function startUserSession($user) {
        // Iniciar la sesión y establecer variables de sesión
        session_start();
        $_SESSION['user_id'] = $user['id_usuario'];
        $_SESSION['username'] = $user['nombre_usuario'];
        $_SESSION['role'] = $user['id_rol'];
    }

    private function redirectUserByRole($roleId) {
        // Redirigir al usuario según su rol
        switch ($roleId) {
            case 1: // Administrador
                header('Location: index.php');
                break;
            case 2: // Asistente
                header('Location: index.php?controller=reserva&action=index'); // Redirigir a la lista de reservas
                break;
            case 3: // Profesor
                header('Location: index.php?controller=reserva&action=index');
                break;
            default:
                $this->showLoginError("Unauthorized role");
                break;
        }
        exit;
    }

    private function showLoginError($error) {
        // Mostrar la página de login con un mensaje de error
        $error;
        require_once 'views/login.php';
        exit;
    }
}

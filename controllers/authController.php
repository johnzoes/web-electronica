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
    
            // Verificar si el usuario existe
            if ($user) {
                // Iniciar la sesión
                session_start();
    
                if ($user['id_rol'] == 1) { // Si el rol es administrador
                    if ($user['password'] == $password) {
                        // Establecer la sesión para el administrador
                        $_SESSION['user_id'] = $user['id_usuario'];
                        $_SESSION['username'] = $user['nombre_usuario'];
                        $_SESSION['role'] = $user['id_rol'];
                        header('Location: index.php?controller=item&action=index');
                        exit;
                    } else {
                        // Contraseña incorrecta para el administrador
                        $error = "Invalid username or password";
                        require_once 'views/login.php';
                    }
                } else { // Si el rol no es administrador, verificar la contraseña
                    if (password_verify($password, $user['password'])) {
                        // Establecer la sesión para el usuario no administrador
                        $_SESSION['user_id'] = $user['id_usuario'];
                        $_SESSION['username'] = $user['nombre_usuario'];
                        $_SESSION['role'] = $user['id_rol'];

                         // Redirigir según el rol
                    if
                     ($user['id_rol'] == 2) { // Si el rol es para asistente
                        header('Location: index.php?controller=asistente&action=index');

                    } else if 
                    ($user['id_rol'] == 3)  { // Si el rol es para profesor
                        header('Location: index.php?controller=profesor&action=index');
                     }
                
                        exit;
                    } else {
                        // Contraseña incorrecta para el usuario no administrador
                        $error = "Invalid username or password";
                        require_once 'views/login.php';
                    }
                }
            } else {
                // Usuario no encontrado, mostrar mensaje de error
                $error = "Invalid username or password";
                require_once 'views/login.php';
            }
        }
    }
    
    
    
    
    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php?controller=auth&action=login');
        exit;
    }
}
?>

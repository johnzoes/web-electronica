<?php
require_once 'database.php';

class UserRole {
    private static $conexion;

    public static function init() {
        self::$conexion = $GLOBALS['conexion'];
    }

    public function getRoleIdByUserId($userId){
        $stmt = self::$conexion->prepare("SELECT id_rol FROM usuario WHERE id_usuario = ?");
        if($stmt === false){
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['id_rol'];
    }
}

UserRole::init();
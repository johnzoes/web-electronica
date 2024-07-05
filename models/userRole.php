<?php
require_once 'database.php';

class UserRole {
    private static $conexion;

    public static function init() {
        self::$conexion = $GLOBALS['conexion'];
    }

    public function getRoleIdByUserId($userId) {
        $roleId = null; // Inicializar la variable

        $query = "SELECT id_rol FROM usuario WHERE id_usuario = ?";
        if ($stmt = $this->conexion->prepare($query)) {
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $stmt->bind_result($roleId);
            $stmt->fetch();
            $stmt->close();
            return $roleId;
        }
        return null;
    }
}

UserRole::init();
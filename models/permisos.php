<?php
require_once 'database.php';

class Permission {
    private static $conexion;

    public static function init() {
        self::$conexion = $GLOBALS['conexion'];
    }

    public function hasPermission($roleId, $permission) {
        $stmt = self::$conexion->prepare("SELECT COUNT(*) as cnt FROM role_permission WHERE id_rol = ? AND id_permiso = (SELECT id_permiso FROM permisos WHERE nombre = ?)");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("is", $roleId, $permission);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['cnt'] > 0;
    }
}

Permission::init();
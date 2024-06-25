<?php
require_once 'database.php';

class Rol {
    private static $conexion;

    public static function init() {
        self::$conexion = $GLOBALS['conexion'];
    }

    public static function all() {
        $result = self::$conexion->query("SELECT * FROM rol");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function find($id) {
        $stmt = self::$conexion->prepare("SELECT * FROM rol WHERE id_rol = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function create($data) {
        $stmt = self::$conexion->prepare("INSERT INTO rol (nombre) VALUES (?)");
        $stmt->bind_param("s", $data['nombre']);
        return $stmt->execute();
    }

    public static function update($id, $data) {
        $stmt = self::$conexion->prepare("UPDATE rol SET nombre = ? WHERE id_rol = ?");
        $stmt->bind_param("si", $data['nombre'], $id);
        return $stmt->execute();
    }

    public static function delete($id) {
        $stmt = self::$conexion->prepare("DELETE FROM rol WHERE id_rol = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

Rol::init();
?>

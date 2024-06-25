<?php
require_once 'database.php';

class Salon {
    private static $conexion;

    public static function init() {
        self::$conexion = $GLOBALS['conexion'];
    }

    public static function all() {
        $result = self::$conexion->query("SELECT * FROM salon");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function find($id) {
        $stmt = self::$conexion->prepare("SELECT * FROM salon WHERE id_salon = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function create($data) {
        $stmt = self::$conexion->prepare("INSERT INTO salon (nombre_salon) VALUES (?)");
        $stmt->bind_param("s", $data['nombre_salon']);
        return $stmt->execute();
    }

    public static function update($id, $data) {
        $stmt = self::$conexion->prepare("UPDATE salon SET nombre_salon = ? WHERE id_salon = ?");
        $stmt->bind_param("si", $data['nombre_salon'], $id);
        return $stmt->execute();
    }

    public static function delete($id) {
        $stmt = self::$conexion->prepare("DELETE FROM salon WHERE id_salon = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

Salon::init();
?>

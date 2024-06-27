<?php
require_once 'database.php';

class Turno {
    private static $conexion;

    public static function init() {
        self::$conexion = $GLOBALS['conexion'];
    }

    public static function all() {
        $result = self::$conexion->query("SELECT * FROM turno");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function find($id){
        $stmt = self::$conexion->prepare("SELECT * FROM turno WHERE id_turno = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

}

Turno::init();


<?php
require_once 'database.php';

class Asistente {
    private static $conexion;

    public static function init() {
        self::$conexion = $GLOBALS['conexion'];
    }

    public static function all() {
        $result = self::$conexion->query("SELECT * FROM asistente");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function find($id) {
        $stmt = self::$conexion->prepare("SELECT * FROM asistente WHERE id_asistente = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public static function create($data) {
        $stmt = self::$conexion->prepare("INSERT INTO asistente (id_usuario, id_turno, id_salon) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $data['id_usuario'], $data['id_turno'], $data['id_salon']);
        return $stmt->execute();
    }


    public static function updateByUsuarioId($id_usuario, $data) {
        $stmt = self::$conexion->prepare("UPDATE asistente SET id_turno = ?, id_salon = ? WHERE id_usuario = ?");
        $stmt->bind_param("iii", $data['id_turno'], $data['id_salon'], $id_usuario);
        return $stmt->execute();
    }   

    public static function deleteByUsuarioId($id_usuario) {
        $stmt = self::$conexion->prepare("DELETE FROM asistente WHERE id_usuario = ?");
        $stmt->bind_param("i", $id_usuario);
        return $stmt->execute();
    }

    public static function findAsistenteByUsuarioId($id_usuario) {
        $stmt = self::$conexion->prepare("SELECT * FROM asistente WHERE id_usuario = ?");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
}
}
Asistente::init();
?>

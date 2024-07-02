<?php
require_once 'database.php';

class Profesor {
    private static $conexion;

    public static function init() {
        self::$conexion = $GLOBALS['conexion'];
    }

    public static function all() {
        $result = self::$conexion->query("SELECT * FROM profesor");
        return $result->fetch_all(MYSQLI_ASSOC);
        
    }

    public static function find($id) {
        $stmt = self::$conexion->prepare("SELECT * FROM profesor WHERE id_profesor = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public static function create($data) {
        $stmt = self::$conexion->prepare("INSERT INTO profesor (id_usuario) VALUES (?)");
        $stmt->bind_param("i", $data['id_usuario']);
        return $stmt->execute();
    }

    public static function update($id, $data) {
        $stmt = self::$conexion->prepare("UPDATE profesor SET nombre = ? WHERE id_profesor = ?");
        $stmt->bind_param("si", $data['nombre'], $id);
        return $stmt->execute();
    }

    public static function delete($id) {
        $stmt = self::$conexion->prepare("DELETE FROM profesor WHERE id_profesor = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

Profesor::init();
?>

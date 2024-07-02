<?php
require_once 'database.php';

class Prestamo {
    private static $conexion;

    public static function init() {
        self::$conexion = $GLOBALS['conexion'];
    }

    public static function all() {
        $result = self::$conexion->query("SELECT * FROM prestamo");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function find($id) {
        $stmt = self::$conexion->prepare("SELECT * FROM prestamo WHERE id_prestamo = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function create($data) {
        $stmt = self::$conexion->prepare("INSERT INTO prestamo (id_reserva, hora, fecha) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $data['id_reserva'], $data['hora'], $data['fecha']);
        return $stmt->execute();
    }

    public static function update($id, $data) {
        $stmt = self::$conexion->prepare("UPDATE prestamo SET id_reserva = ?, hora = ?, fecha = ? WHERE id_prestamo = ?");
        $stmt->bind_param("issi", $data['id_reserva'], $data['hora'], $data['fecha'], $id);
        return $stmt->execute();
    }

    public static function delete($id) {
        $stmt = self::$conexion->prepare("DELETE FROM prestamo WHERE id_prestamo = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

Prestamo::init();
?>

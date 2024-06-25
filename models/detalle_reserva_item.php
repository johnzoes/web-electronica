<?php
require_once 'database.php';

class DetalleReservaItem {
    private static $conexion;

    public static function init() {
        self::$conexion = $GLOBALS['conexion'];
    }

    public static function all() {
        $result = self::$conexion->query("SELECT * FROM detalle_reserva_item");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function find($id) {
        $stmt = self::$conexion->prepare("SELECT * FROM detalle_reserva_item WHERE id_detalle = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function create($data) {
        $stmt = self::$conexion->prepare("INSERT INTO detalle_reserva_item (id_reserva, id_item, fecha_reserva, hora_reserva) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $data['id_reserva'], $data['id_item'], $data['fecha_reserva'], $data['hora_reserva']);
        return $stmt->execute();
    }

    public static function update($id, $data) {
        $stmt = self::$conexion->prepare("UPDATE detalle_reserva_item SET id_reserva = ?, id_item = ?, fecha_reserva = ?, hora_reserva = ? WHERE id_detalle = ?");
        $stmt->bind_param("iissi", $data['id_reserva'], $data['id_item'], $data['fecha_reserva'], $data['hora_reserva'], $id);
        return $stmt->execute();
    }

    public static function delete($id) {
        $stmt = self::$conexion->prepare("DELETE FROM detalle_reserva_item WHERE id_detalle = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

DetalleReservaItem::init();

?>

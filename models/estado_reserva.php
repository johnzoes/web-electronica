<?php
require_once 'database.php';

class EstadoReserva {
    private static $conexion;

    public static function init() {
        self::$conexion = $GLOBALS['conexion'];
    }

    public static function all() {
        $result = self::$conexion->query("SELECT * FROM estado_reserva");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function find($id) {
        $stmt = self::$conexion->prepare("SELECT * FROM estado_reserva WHERE id_estado = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public static function getEstadoByReserva($id_reserva){
        $stmt = self::$conexion->prepare("SELECT * FROM estado_reserva WHERE id_reserva = ?");
        $stmt->bind_param("i", $id_reserva);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }



    public static function create($data) {
        $stmt = self::$conexion->prepare("INSERT INTO estado_reserva (id_reserva, estado, motivo_rechazo, hora_estado, fecha_estado) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $data['id_reserva'], $data['estado'], $data['motivo_rechazo'], $data['hora_estado'], $data['fecha_estado']);
        return $stmt->execute();
    }

    public static function update($id, $data) {
        $stmt = self::$conexion->prepare("UPDATE estado_reserva SET id_reserva = ?, estado = ?, motivo_rechazo = ?, hora_estado = ?, fecha_estado = ? WHERE id_estado = ?");
        $stmt->bind_param("issssi", $data['id_reserva'], $data['estado'], $data['motivo_rechazo'], $data['hora_estado'], $data['fecha_estado'], $id);
        return $stmt->execute();
    }

    public static function delete($id) {
        $stmt = self::$conexion->prepare("DELETE FROM estado_reserva WHERE id_estado = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

EstadoReserva::init();
?>

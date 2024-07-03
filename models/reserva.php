<?php
require_once 'database.php';

class Reserva {
    private static $conexion;

    public static function init() {
        self::$conexion = $GLOBALS['conexion'];
    }

    public static function all() {
        $result = self::$conexion->query("SELECT * FROM reserva");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function find($id) {
        $stmt = self::$conexion->prepare("SELECT * FROM reserva WHERE id_reserva = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function create($data) {
        $stmt = self::$conexion->prepare("INSERT INTO reserva (fecha_prestamo, id_profesor, id_unidad_didactica, id_turno) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siii", $data['fecha_prestamo'], $data['id_profesor'], $data['id_unidad_didactica'], $data['id_turno']);
        $stmt->execute();
        return self::$conexion->insert_id;  // Devolver el ID de la reserva creada
    }

    public static function update($id, $data) {
        $stmt = self::$conexion->prepare("UPDATE reserva SET fecha_prestamo = ?, id_profesor = ?, id_unidad_didactica = ?, id_turno = ? WHERE id_reserva = ?");
        $stmt->bind_param("siiii", $data['fecha_prestamo'], $data['id_profesor'], $data['id_unidad_didactica'], $data['id_turno'], $id);
        return $stmt->execute();
    }


    public static function delete($id) {


        //primero eliminar el estado de la reserva que se crea con el id_reserva
        $stmtDeleteEstado = self::$conexion->prepare("DELETE FROM estado_reserva WHERE id_reserva = ?");
        $stmtDeleteEstado->bind_param("i", $id);
        $stmtDeleteEstado->execute();
        $stmtDeleteEstado->close();

        // Eliminar detalles de reserva primero
        $stmtDeleteDetalle = self::$conexion->prepare("DELETE FROM detalle_reserva_item WHERE id_reserva = ?");
        $stmtDeleteDetalle->bind_param("i", $id);
        $stmtDeleteDetalle->execute();
        $stmtDeleteDetalle->close();


        // Luego eliminar la reserva
        $stmtDeleteReserva = self::$conexion->prepare("DELETE FROM reserva WHERE id_reserva = ?");
        $stmtDeleteReserva->bind_param("i", $id);
        $success = $stmtDeleteReserva->execute();
        $stmtDeleteReserva->close();
    
        return $success;
    }


    
}

Reserva::init();

<?php
require_once 'database.php';

class Reserva {
    private static $conexion;

    public static function init() {
        self::$conexion = $GLOBALS['conexion'];
    }

    /**
     * Obtiene todas las reservas.
     *
     * @return array
     * @throws Exception
     */
    public static function all() {
        $result = self::$conexion->query("SELECT * FROM reserva");
        if ($result === false) {
            throw new Exception("Error en la consulta: " . self::$conexion->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Encuentra una reserva por ID.
     *
     * @param int $id
     * @return array|null
     * @throws Exception
     */
    public static function find($id) {
        $stmt = self::$conexion->prepare("SELECT * FROM reserva WHERE id_reserva = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Crea una nueva reserva.
     *
     * @param array $data
     * @return int|false
     * @throws Exception
     */
    public static function create($data) {
        $stmt = self::$conexion->prepare("INSERT INTO reserva (fecha_prestamo, id_profesor, id_unidad_didactica, id_turno) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("siii", $data['fecha_prestamo'], $data['id_profesor'], $data['id_unidad_didactica'], $data['id_turno']);
        $stmt->execute();
        if ($stmt->error) {
            throw new Exception("Error ejecutando la consulta: " . $stmt->error);
        }
        return self::$conexion->insert_id;
    }

    /**
     * Actualiza una reserva por ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public static function update($id, $data) {
        self::updateItemsQuantity($data['items']);
        $stmt = self::$conexion->prepare("UPDATE reserva SET fecha_prestamo = ?, id_profesor = ?, id_unidad_didactica = ?, id_turno = ? WHERE id_reserva = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("siiii", $data['fecha_prestamo'], $data['id_profesor'], $data['id_unidad_didactica'], $data['id_turno'], $id);
        return $stmt->execute();
    }

    /**
     * Elimina una reserva por ID.
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public static function delete($id) {
        // Eliminar detalles de la reserva
        $stmtDeleteDetalle = self::$conexion->prepare("DELETE FROM detalle_reserva_item WHERE id_reserva = ?");
        if ($stmtDeleteDetalle === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmtDeleteDetalle->bind_param("i", $id);
        $stmtDeleteDetalle->execute();
        $stmtDeleteDetalle->close();

        // Eliminar la reserva
        $stmtDeleteReserva = self::$conexion->prepare("DELETE FROM reserva WHERE id_reserva = ?");
        if ($stmtDeleteReserva === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmtDeleteReserva->bind_param("i", $id);
        $success = $stmtDeleteReserva->execute();
        $stmtDeleteReserva->close();

        return $success;
    }

    /**
     * Encuentra reservas por profesor ID.
     *
     * @param int $profesorId
     * @return array
     * @throws Exception
     */
    public static function findByProfesor($profesorId) {
        $stmt = self::$conexion->prepare("
            SELECT r.id_reserva, r.fecha_prestamo, u.nombre AS nombre_unidad_didactica, t.nombre AS nombre_turno
            FROM reserva r
            JOIN unidad_didactica u ON r.id_unidad_didactica = u.id_unidad_didactica
            JOIN turno t ON r.id_turno = t.id_turno
            WHERE r.id_profesor = ?
        ");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $profesorId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }    
    
    /**
     * Obtiene todas las reservas con detalles.
     *
     * @return array
     * @throws Exception
     */
    public static function allWithDetails() {
        $query = "
            SELECT r.id_reserva, r.fecha_prestamo, u.nombre AS nombre_unidad_didactica, t.nombre AS nombre_turno, usr.nombre AS nombre_profesor
            FROM reserva r
            JOIN unidad_didactica u ON r.id_unidad_didactica = u.id_unidad_didactica
            JOIN turno t ON r.id_turno = t.id_turno
            JOIN profesor p ON r.id_profesor = p.id_profesor
            JOIN usuario usr ON p.id_usuario = usr.id_usuario
        ";
        $result = self::$conexion->query($query);
        if ($result === false) {
            throw new Exception("Error en la consulta: " . self::$conexion->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Encuentra una reserva con detalles por ID.
     *
     * @param int $id
     * @return array|null
     * @throws Exception
     */
    public static function findWithDetails($id) {
        $stmt = self::$conexion->prepare("
            SELECT r.id_reserva, r.fecha_prestamo, u.nombre AS nombre_unidad_didactica, t.nombre AS nombre_turno, usr.nombre AS nombre_profesor
            FROM reserva r
            JOIN unidad_didactica u ON r.id_unidad_didactica = u.id_unidad_didactica
            JOIN turno t ON r.id_turno = t.id_turno
            JOIN profesor p ON r.id_profesor = p.id_profesor
            JOIN usuario usr ON p.id_usuario = usr.id_usuario
            WHERE r.id_reserva = ?
        ");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }    

    /**
     * Actualiza la cantidad de ítems no únicos.
     *
     * @param array $items
     * @throws Exception
     */
    private static function updateItemsQuantity($items) {
        foreach ($items as $itemId => $quantity) {
            $stmt = self::$conexion->prepare("UPDATE item SET cantidad = cantidad - ? WHERE id_item = ? AND es_unico = 0");
            if ($stmt === false) {
                throw new Exception("Error preparando la consulta: " . self::$conexion->error);
            }
            $stmt->bind_param("ii", $quantity, $itemId);
            $stmt->execute();
        }
    }

    // Métodos usando $this->db corregidos a usar self::$conexion

   // Obtener todas las reservas pendientes por su estado
   public function getReservasPendientes() {
    $query = "
        SELECT r.id_reserva, r.fecha_prestamo, ud.nombre AS unidad_didactica, 
               t.nombre AS turno, u.nombre AS profesor, es.estado AS estado_reserva
        FROM reserva r
        INNER JOIN unidad_didactica ud ON r.id_unidad_didactica = ud.id_unidad_didactica
        INNER JOIN turno t ON r.id_turno = t.id_turno
        INNER JOIN profesor p ON r.id_profesor = p.id_profesor
        INNER JOIN usuario u ON p.id_usuario = u.id_usuario
        INNER JOIN estado_reserva es ON r.id_reserva = es.id_reserva
        WHERE es.estado = 'pendiente'
    ";
    $result = self::$conexion->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Obtener el historial de reservas completadas
public function getHistorialReservas() {
    $query = "
        SELECT r.id_reserva, r.fecha_prestamo, ud.nombre AS unidad_didactica, 
               t.nombre AS turno, u.nombre AS profesor, es.estado AS estado_reserva
        FROM reserva r
        INNER JOIN unidad_didactica ud ON r.id_unidad_didactica = ud.id_unidad_didactica
        INNER JOIN turno t ON r.id_turno = t.id_turno
        INNER JOIN profesor p ON r.id_profesor = p.id_profesor
        INNER JOIN usuario u ON p.id_usuario = u.id_usuario
        INNER JOIN estado_reserva es ON r.id_reserva = es.id_reserva
        WHERE es.estado = 'completada'
    ";
    $result = self::$conexion->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Obtener reservas rechazadas
public function getReservasRechazadas() {
    $query = "
        SELECT r.id_reserva, r.fecha_prestamo, ud.nombre AS unidad_didactica, 
               t.nombre AS turno, u.nombre AS profesor, es.motivo_rechazo, es.estado AS estado_reserva
        FROM reserva r
        INNER JOIN unidad_didactica ud ON r.id_unidad_didactica = ud.id_unidad_didactica
        INNER JOIN turno t ON r.id_turno = t.id_turno
        INNER JOIN profesor p ON r.id_profesor = p.id_profesor
        INNER JOIN usuario u ON p.id_usuario = u.id_usuario
        INNER JOIN estado_reserva es ON r.id_reserva = es.id_reserva
        WHERE es.estado = 'rechazada'
    ";
    $result = self::$conexion->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}


}

Reserva::init();

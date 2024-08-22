<?php
require_once 'database.php';

class DetalleReservaItem {
    private static $conexion;

    public static function init() {
        self::$conexion = $GLOBALS['conexion'];
    }

    /**
     * Obtiene todos los detalles de reserva de items.
     *
     * @return array
     * @throws Exception
     */
    public static function all() {
        $result = self::$conexion->query("SELECT * FROM detalle_reserva_item");
        if ($result === false) {
            throw new Exception("Error en la consulta: " . self::$conexion->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Encuentra un detalle de reserva de item por ID.
     *
     * @param int $id
     * @return array|null
     * @throws Exception
     */
    public static function find($id) {
        $stmt = self::$conexion->prepare("SELECT * FROM detalle_reserva_item WHERE id_detalle = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Crea un nuevo detalle de reserva de item.
     *
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public static function create($data) {
        // Preparar la consulta de inserción
        $stmt = self::$conexion->prepare("INSERT INTO detalle_reserva_item (id_reserva, id_item, fecha_reserva, hora_reserva) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        
        // Enlazar los parámetros
        $stmt->bind_param("iiss", $data['id_reserva'], $data['id_item'], $data['fecha_reserva'], $data['hora_reserva']);
        
        // Ejecutar la consulta
        $result = $stmt->execute();
        
        // Verificar errores
        if ($stmt->error) {
            throw new Exception("Error ejecutando la consulta: " . $stmt->error);
        }
        
        // Obtener el ID del nuevo registro
        $insertedId = self::$conexion->insert_id;
        
        // Cerrar la declaración
        $stmt->close();
        
        // Devolver el ID del nuevo registro
        return $insertedId;
    }
    

    /**
     * Actualiza un detalle de reserva de item por ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public static function update($id, $data) {
        $stmt = self::$conexion->prepare("UPDATE detalle_reserva_item SET id_reserva = ?, id_item = ?, fecha_reserva = ?, hora_reserva = ? WHERE id_detalle = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("iissi", $data['id_reserva'], $data['id_item'], $data['fecha_reserva'], $data['hora_reserva'], $id);
        return $stmt->execute();
    }

    /**
     * Elimina un detalle de reserva de item por ID.
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public static function delete($id) {
        $stmt = self::$conexion->prepare("DELETE FROM detalle_reserva_item WHERE id_detalle = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    /**
     * Encuentra detalles de reserva de item por ID de reserva.
     *
     * @param int $id
     * @return array
     * @throws Exception
     */
    public static function findByReserva($id) {
        $stmt = self::$conexion->prepare("SELECT * FROM detalle_reserva_item WHERE id_reserva = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $detalles = [];
        
        while ($detalle = $result->fetch_assoc()) {
            $detalles[] = $detalle;
        }
        
        return $detalles;
    }
}

DetalleReservaItem::init();
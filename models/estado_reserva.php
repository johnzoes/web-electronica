<?php
require_once 'database.php';

class EstadoReserva {
    private static $conexion;

    public static function init() {
        self::$conexion = $GLOBALS['conexion'];
    }

    /**
     * Obtiene todos los estados de reservas.
     *
     * @return array
     * @throws Exception
     */
    public static function all() {
        $result = self::$conexion->query("SELECT * FROM estado_reserva");
        if ($result === false) {
            throw new Exception("Error en la consulta: " . self::$conexion->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Encuentra un estado de reserva por ID.
     *
     * @param int $id
     * @return array|null
     * @throws Exception
     */
    public static function find($id) {
        $stmt = self::$conexion->prepare("SELECT * FROM estado_reserva WHERE id_estado = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Encuentra el estado de una reserva por ID de reserva.
     *
     * @param int $id_reserva
     * @return array|null
     * @throws Exception
     */
    public static function getEstadoByReserva($id_reserva) {
        $stmt = self::$conexion->prepare("SELECT * FROM estado_reserva WHERE id_reserva = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $id_reserva);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    
    /*Crea un nuevo estado de reserva.*/
 
    public static function create($data) {
        // Preparar la llamada al procedimiento almacenado
        $stmt = self::$conexion->prepare("CALL InsertEstadoReserva(?, ?, ?)");
        
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
    
        // Enlazar parámetros, excluyendo fecha y hora
        $stmt->bind_param("iss", 
            $data['id_reserva'], 
            $data['estado'], 
            $data['motivo_rechazo']
        );
    
        // Ejecutar el procedimiento almacenado
        $result = $stmt->execute();
    
        // Verificar errores
        if ($stmt->error) {
            throw new Exception("Error ejecutando el procedimiento almacenado: " . $stmt->error);
        }
    
        // Cerrar la declaración
        $stmt->close();
    
        return $result;
    }
    

    /**
     * Actualiza un estado de reserva por ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public static function update($id, $data) {
        $stmt = self::$conexion->prepare("UPDATE estado_reserva SET id_reserva = ?, estado = ?, motivo_rechazo = ?, hora_estado = ?, fecha_estado = ? WHERE id_estado = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("issssi", $data['id_reserva'], $data['estado'], $data['motivo_rechazo'], $data['hora_estado'], $data['fecha_estado'], $id);
        return $stmt->execute();
    }

    /**
     * Elimina un estado de reserva por ID.
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public static function delete($id) {
        $stmt = self::$conexion->prepare("DELETE FROM estado_reserva WHERE id_estado = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public static function updateByReservaId($id_reserva, $data) {
        // Preparar la llamada al procedimiento almacenado
        $stmt = self::$conexion->prepare("CALL InsertEstadoReserva(?, ?, ?)");
        
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
    
        // Enlazar parámetros, excluyendo fecha y hora
        $stmt->bind_param("iss", 
            $id_reserva, 
            $data['estado'], 
            $data['motivo_rechazo']
        );
    
        // Ejecutar el procedimiento almacenado
        $result = $stmt->execute();
    
        // Verificar errores
        if ($stmt->error) {
            throw new Exception("Error ejecutando el procedimiento almacenado: " . $stmt->error);
        }
    
        // Cerrar la declaración
        $stmt->close();
    
        return $result;
    }     
}



EstadoReserva::init();
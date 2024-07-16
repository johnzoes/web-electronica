<?php
require_once 'database.php';

class Prestamo {
    private static $conexion;

    public static function init() {
        self::$conexion = $GLOBALS['conexion'];
    }

    /**
     * Obtiene todos los préstamos.
     *
     * @return array
     * @throws Exception
     */
    public static function all() {
        $result = self::$conexion->query("SELECT * FROM prestamo");
        if ($result === false) {
            throw new Exception("Error en la consulta: " . self::$conexion->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Encuentra un préstamo por ID.
     *
     * @param int $id
     * @return array|null
     * @throws Exception
     */
    public static function find($id) {
        $stmt = self::$conexion->prepare("SELECT * FROM prestamo WHERE id_prestamo = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Crea un nuevo préstamo.
     *
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public static function create($data) {
        $stmt = self::$conexion->prepare("INSERT INTO prestamo (id_reserva, hora, fecha) VALUES (?, ?, ?)");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("iss", $data['id_reserva'], $data['hora'], $data['fecha']);
        return $stmt->execute();
    }

    /**
     * Actualiza un préstamo por ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public static function update($id, $data) {
        $stmt = self::$conexion->prepare("UPDATE prestamo SET id_reserva = ?, hora = ?, fecha = ? WHERE id_prestamo = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("issi", $data['id_reserva'], $data['hora'], $data['fecha'], $id);
        return $stmt->execute();
    }

    /**
     * Elimina un préstamo por ID.
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public static function delete($id) {
        $stmt = self::$conexion->prepare("DELETE FROM prestamo WHERE id_prestamo = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

Prestamo::init();
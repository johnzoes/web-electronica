<?php
require_once 'database.php';

class Ubicacion {
    private static $conexion;

    public static function init() {
        self::$conexion = $GLOBALS['conexion'];
    }

    /**
     * Obtiene todas las ubicaciones.
     *
     * @return array
     * @throws Exception
     */
    public static function all() {
        $result = self::$conexion->query("SELECT * FROM ubicacion");
        if ($result === false) {
            throw new Exception("Error en la consulta: " . self::$conexion->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Encuentra una ubicación por ID.
     *
     * @param int $id
     * @return array|null
     * @throws Exception
     */
    public static function find($id) {
        $stmt = self::$conexion->prepare("SELECT * FROM ubicacion WHERE id_ubicacion = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Crea una nueva ubicación.
     *
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public static function create($data) {
        $stmt = self::$conexion->prepare("INSERT INTO ubicacion (id_salon, nombre_armario) VALUES (?, ?)");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("is", $data['id_salon'], $data['nombre_armario']);
        return $stmt->execute();
    }

    /**
     * Actualiza una ubicación por ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public static function update($id, $data) {
        $stmt = self::$conexion->prepare("UPDATE ubicacion SET id_salon = ?, nombre_armario = ? WHERE id_ubicacion = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("isi", $data['id_salon'], $data['nombre_armario'], $id);
        return $stmt->execute();
    }

    /**
     * Elimina una ubicación por ID.
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public static function delete($id) {
        $stmt = self::$conexion->prepare("DELETE FROM ubicacion WHERE id_ubicacion = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    /**
     * Encuentra ubicaciones por ID de salón.
     *
     * @param int $id_salon
     * @return array
     * @throws Exception
     */
    public static function findBySalonId($id_salon) {
        $stmt = self::$conexion->prepare("SELECT * FROM ubicacion WHERE id_salon = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $id_salon);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Encuentra ubicaciones por ID de salón y nombre de armario.
     *
     * @param int $id_salon
     * @param string $nombre_armario
     * @return array
     * @throws Exception
     */
    public static function findUbicacionByArmarioAndSalon($id_salon, $nombre_armario) {
        $stmt = self::$conexion->prepare("SELECT * FROM ubicacion WHERE id_salon = ? AND nombre_armario = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("is", $id_salon, $nombre_armario);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

Ubicacion::init();
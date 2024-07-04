<?php
require_once 'database.php';

class Asistente {
    private static $conexion;

    public static function init() {
        self::$conexion = $GLOBALS['conexion'];
    }

    /**
     * Obtiene todos los asistentes.
     *
     * @return array
     */
    public static function all() {
        $result = self::$conexion->query("SELECT * FROM asistente");
        if ($result === false) {
            throw new Exception("Error en la consulta: " . self::$conexion->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Encuentra un asistente por ID.
     *
     * @param int $id
     * @return array|null
     */
    public static function find($id) {
        $stmt = self::$conexion->prepare("SELECT * FROM asistente WHERE id_asistente = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    /**
     * Crea un nuevo asistente.
     *
     * @param array $data
     * @return bool
     */
    public static function create($data) {
        $stmt = self::$conexion->prepare("INSERT INTO asistente (id_usuario, id_turno, id_salon) VALUES (?, ?, ?)");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("iii", $data['id_usuario'], $data['id_turno'], $data['id_salon']);
        return $stmt->execute();
    }

    /**
     * Actualiza un asistente por ID de usuario.
     *
     * @param int $id_usuario
     * @param array $data
     * @return bool
     */
    public static function updateByUsuarioId($id_usuario, $data) {
        $stmt = self::$conexion->prepare("UPDATE asistente SET id_turno = ?, id_salon = ? WHERE id_usuario = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("iii", $data['id_turno'], $data['id_salon'], $id_usuario);
        return $stmt->execute();
    }   

    /**
     * Elimina un asistente por ID de usuario.
     *
     * @param int $id_usuario
     * @return bool
     */
    public static function deleteByUsuarioId($id_usuario) {
        $stmt = self::$conexion->prepare("DELETE FROM asistente WHERE id_usuario = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $id_usuario);
        return $stmt->execute();
    }

    /**
     * Encuentra un asistente por ID de usuario.
     *
     * @param int $id_usuario
     * @return array|null
     */
    public static function findAsistenteByUsuarioId($id_usuario) {
        $stmt = self::$conexion->prepare("SELECT * FROM asistente WHERE id_usuario = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}

Asistente::init();

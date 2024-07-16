<?php
require_once 'database.php';

class Usuario {
    private static $conexion;

    public static function init() {
        self::$conexion = $GLOBALS['conexion'];
    }

    /**
     * Obtiene todos los usuarios.
     *
     * @return array
     * @throws Exception
     */
    public static function all() {
        $result = self::$conexion->query("SELECT * FROM usuario");
        if ($result === false) {
            throw new Exception("Error en la consulta: " . self::$conexion->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Encuentra un usuario por ID.
     *
     * @param int $id
     * @return array|null
     * @throws Exception
     */
    public static function find($id) {
        $stmt = self::$conexion->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Crea un nuevo usuario.
     *
     * @param array $data
     * @return int|false
     * @throws Exception
     */
    public static function create($data) {
        $stmt = self::$conexion->prepare("INSERT INTO usuario (nombre_usuario, nombre, apellidos, password, id_rol) VALUES (?, ?, ?, ?, ?)");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("ssssi", $data['nombre_usuario'], $data['nombre'], $data['apellidos'], $data['password'], $data['id_rol']);
        $stmt->execute();
        if ($stmt->error) {
            throw new Exception("Error ejecutando la consulta: " . $stmt->error);
        }
        return self::$conexion->insert_id;  // Devolver el ID del usuario creado
    }

    /**
     * Actualiza un usuario por ID (sin cambiar la contraseña ni el rol).
     *
     * @param int $id
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public static function update($id, $data) {
        $stmt = self::$conexion->prepare("UPDATE usuario SET nombre_usuario = ?, nombre = ?, apellidos = ? WHERE id_usuario = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("sssi", $data['nombre_usuario'], $data['nombre'], $data['apellidos'], $id);
        return $stmt->execute();
    }

    /**
     * Elimina un usuario por ID.
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public static function delete($id) {
        $stmt = self::$conexion->prepare("DELETE FROM usuario WHERE id_usuario = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    /**
     * Encuentra un usuario por nombre de usuario.
     *
     * @param string $nombre_usuario
     * @return array|null
     * @throws Exception
     */
    public static function findByUsername($nombre_usuario) {
        $stmt = self::$conexion->prepare("SELECT * FROM usuario WHERE nombre_usuario = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            return null; // No se encontró ningún usuario
        }
        return $result->fetch_assoc();
    }
}

Usuario::init();
<?php
require_once 'database.php';

class Categoria {
    private static $conexion;

    public static function init() {
        self::$conexion = $GLOBALS['conexion'];
    }

    /**
     * Obtiene todas las categorías.
     *
     * @return array
     * @throws Exception
     */
    public static function all() {
        $result = self::$conexion->query("SELECT * FROM categoria");
        if ($result === false) {
            throw new Exception("Error en la consulta: " . self::$conexion->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Encuentra una categoría por ID.
     *
     * @param int $id
     * @return array|null
     * @throws Exception
     */
    public static function find($id) {
        $stmt = self::$conexion->prepare("SELECT * FROM categoria WHERE id_categoria = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Crea una nueva categoría.
     *
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public static function create($data) {
        $stmt = self::$conexion->prepare("INSERT INTO categoria (nombre_categoria) VALUES (?)");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("s", $data['nombre_categoria']);
        return $stmt->execute();
    }

    /**
     * Actualiza una categoría por ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public static function update($id, $data) {
        $stmt = self::$conexion->prepare("UPDATE categoria SET nombre_categoria = ? WHERE id_categoria = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("si", $data['nombre_categoria'], $id);
        return $stmt->execute();
    }

    /**
     * Elimina una categoría por ID.
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public static function delete($id) {
        $stmt = self::$conexion->prepare("DELETE FROM categoria WHERE id_categoria = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

Categoria::init();
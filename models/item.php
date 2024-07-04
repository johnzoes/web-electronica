<?php
require_once 'database.php';

class Item {
    private static $conexion;

    public static function init() {
        self::$conexion = $GLOBALS['conexion'];
    }

    /**
     * Obtiene todos los items.
     *
     * @return array
     * @throws Exception
     */
    public static function all() {
        $result = self::$conexion->query("SELECT * FROM item");
        if ($result === false) {
            throw new Exception("Error en la consulta: " . self::$conexion->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Encuentra un item por ID.
     *
     * @param int $id
     * @return array|null
     * @throws Exception
     */
    public static function find($id) {
        $stmt = self::$conexion->prepare("SELECT * FROM item WHERE id_item = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Crea un nuevo item.
     *
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public static function create($data) {
        $stmt = self::$conexion->prepare("INSERT INTO item (codigo_bci, descripcion, cantidad, estado, marca, modelo, imagen, id_ubicacion, nro_inventariado, id_categoria) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("ssissssisi", $data['codigo_bci'], $data['descripcion'], $data['cantidad'], $data['estado'], $data['marca'], $data['modelo'], $data['imagen'], $data['id_ubicacion'], $data['nro_inventariado'], $data['id_categoria']);
        return $stmt->execute();
    }

    /**
     * Actualiza un item por ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public static function update($id, $data) {
        $stmt = self::$conexion->prepare("UPDATE item SET codigo_bci = ?, descripcion = ?, cantidad = ?, estado = ?, marca = ?, modelo = ?, imagen = ?, id_ubicacion = ?, nro_inventariado = ?, id_categoria = ? WHERE id_item = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("ssissssssii", $data['codigo_bci'], $data['descripcion'], $data['cantidad'], $data['estado'], $data['marca'], $data['modelo'], $data['imagen'], $data['id_ubicacion'], $data['nro_inventariado'], $data['id_categoria'], $id);
        return $stmt->execute();
    }

    /**
     * Elimina un item por ID.
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public static function delete($id) {
        $stmt = self::$conexion->prepare("DELETE FROM item WHERE id_item = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    /**
     * Obtiene items por ID de categoría.
     *
     * @param int $id
     * @return array
     * @throws Exception
     */
    public static function getItemsByCategoria($id) {
        $stmt = self::$conexion->prepare("SELECT * FROM item WHERE id_categoria = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $items = [];
        
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        
        return $items;
    }
}

Item::init();
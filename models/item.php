<?php
require_once 'database.php';

class Item {
    private static $conexion;

    public static function init() {
        self::$conexion = $GLOBALS['conexion'];
    }

    public static function all() {
        $result = self::$conexion->query("SELECT * FROM item");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function find($id) {
        $stmt = self::$conexion->prepare("SELECT * FROM item WHERE id_item = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function create($data) {
        $stmt = self::$conexion->prepare("INSERT INTO item (codigo_bci, descripcion, cantidad, estado, marca, modelo, imagen, id_ubicacion, nro_inventariado, id_categoria) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssissssisi", $data['codigo_bci'], $data['descripcion'], $data['cantidad'], $data['estado'], $data['marca'], $data['modelo'], $data['imagen'], $data['id_ubicacion'], $data['nro_inventariado'], $data['id_categoria']);
        return $stmt->execute();
    }

    public static function update($id, $data) {
        $stmt = self::$conexion->prepare("UPDATE item SET codigo_bci = ?, descripcion = ?, cantidad = ?, estado = ?, marca = ?, modelo = ?, imagen = ?, id_ubicacion = ?, nro_inventariado = ?, id_categoria = ? WHERE id_item = ?");
        $stmt->bind_param("ssissssssii", $data['codigo_bci'], $data['descripcion'], $data['cantidad'], $data['estado'], $data['marca'], $data['modelo'], $data['imagen'], $data['id_ubicacion'], $data['nro_inventariado'], $data['id_categoria'], $id);
        return $stmt->execute();
    }

    public static function delete($id) {
        $stmt = self::$conexion->prepare("DELETE FROM item WHERE id_item = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public static function getItemsByCategoria($id){
        $stmt = self::$conexion->prepare("SELECT * FROM item WHERE id_categoria = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $items = [];
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
            return $items;
        } else {
            return []; 
        }
    }

    
}

Item::init();
?>

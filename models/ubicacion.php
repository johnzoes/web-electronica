<?php
require_once 'database.php';

class Ubicacion {
    private static $conexion;

    public static function init() {
        self::$conexion = $GLOBALS['conexion'];
    }

    public static function all() {
        $result = self::$conexion->query("SELECT * FROM ubicacion");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function find($id) {
        $stmt = self::$conexion->prepare("SELECT * FROM ubicacion WHERE id_ubicacion = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function create($data) {
        $stmt = self::$conexion->prepare("INSERT INTO ubicacion (id_salon, nombre_armario) VALUES (?, ?)");
        $stmt->bind_param("is", $data['id_salon'], $data['nombre_armario']);
        return $stmt->execute();
    }

    public static function update($id, $data) {
        $stmt = self::$conexion->prepare("UPDATE ubicacion SET id_salon = ?, nombre_armario = ? WHERE id_ubicacion = ?");
        $stmt->bind_param("isi", $data['id_salon'], $data['nombre_armario'], $id);
        return $stmt->execute();
    }

    public static function delete($id) {
        $stmt = self::$conexion->prepare("DELETE FROM ubicacion WHERE id_ubicacion = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public static function findBySalonId($id_salon){
        $stmt = self::$conexion->prepare("SELECT * FROM ubicacion WHERE id_salon = ?");
        $stmt->bind_param("i", $id_salon); // Debes bindear $id_salon, no $id
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Verificar si hay resultados antes de devolver
        if ($result->num_rows > 0) {
            // Devolver todos los resultados (si esperas múltiples filas)
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            // Devolver un arreglo vacío si no hay resultados
            return array();
        }
    }


    public static function findUbicacionByArmarioAndSalon($id_salon, $nombre_armario){

        $stmt = self::$conexion->prepare("SELECT * FROM ubicacion WHERE id_salon = ? and nombre_armario=?");
        $stmt->bind_param("is", $id_salon, $nombre_armario); 
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return array();
        }
    }
    
}

Ubicacion::init();
?>

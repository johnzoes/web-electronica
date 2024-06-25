<?php
require_once 'database.php';

class Usuario {
    private static $conexion;

    public static function init() {
        self::$conexion = $GLOBALS['conexion'];
    }

    public static function all() {
        $result = self::$conexion->query("SELECT * FROM usuario");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function find($id) {
        $stmt = self::$conexion->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    
    public static function create($data) {
        $stmt = self::$conexion->prepare("INSERT INTO usuario (nombre_usuario, nombre, apellidos, password, id_rol) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $data['nombre_usuario'], $data['nombre'], $data['apellidos'], $data['password'], $data['id_rol']);
        $stmt->execute();
        
        // Devuelve el último ID insertado
        return self::$conexion->insert_id;
    }

    //no se puede actualizar la contraseña ni el rol desde aqui
    public static function update($id, $data) {
        $stmt = self::$conexion->prepare("UPDATE usuario SET nombre_usuario = ?, nombre =?, apellidos=? WHERE id_usuario = ?");
        $stmt->bind_param("sssi", $data['nombre_usuario'],  $data['nombre'], $data['apellidos'], $id);
        return $stmt->execute();
    }

    public static function delete($id) {
        $stmt = self::$conexion->prepare("DELETE FROM usuario WHERE id_usuario = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();



    }
    
    public static function findByUsername($usuario_nombre) {
        $stmt = self::$conexion->prepare("SELECT * FROM usuario WHERE nombre_usuario = ?");
        $stmt->bind_param("s", $usuario_nombre);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows === 0) {
            return null; // No se encontró ningún usuario
        } else {
            return $result->fetch_assoc();
        }
    }

    
}

Usuario::init();
?>

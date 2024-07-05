<?php
class UserRole {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getRoleIdByUserId($userId) {
        $roleId = null; // Inicializar la variable
        $query = "SELECT id_rol FROM usuario WHERE id_usuario = ?";
        if ($stmt = $this->conexion->prepare($query)) {
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $stmt->bind_result($roleId);
            
            if ($stmt->fetch()) {
                // Se encontró un resultado y $roleId se ha asignado correctamente
                $stmt->close();
                return $roleId;
            } else {
                // No se encontró ningún resultado
                $stmt->close();
                return null;
            }
        }
        return null;
    }
}

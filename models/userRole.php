<?php
class UserRole {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getRoleIdByUserId($userId) {
        $roleId = null; // Inicializar la variable
        $query = "SELECT id_rol FROM usuario WHERE id_usuario = ?";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $stmt->bind_result($roleId);
            $stmt->fetch();
            $stmt->close();
            return $roleId;
        } else {
            // Manejo de errores de la preparación de la consulta
            error_log("Error en la preparación de la consulta: " . $this->db->error);
            return null;
        }
    }
}


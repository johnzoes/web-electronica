<?php
class Permission {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function hasPermission($roleId, $permission) {
        // Implementar la lógica para verificar los permisos aquí
        // Este es solo un ejemplo básico
        $query = "SELECT * FROM role_permission WHERE id_rol = ? AND id_permiso = ?";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param("ii", $roleId, $permission);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->close();
                return true;
            } else {
                $stmt->close();
                return false;
            }
        }
        return false;
    }
}


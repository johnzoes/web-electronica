<?php
class Permission {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function hasPermission($roleId, $permissionName) {
        $query = "SELECT 1 
                  FROM role_permission rp
                  INNER JOIN permisos p ON rp.id_permiso = p.id_permiso
                  WHERE rp.id_rol = ? AND p.nombre = ?";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param("is", $roleId, $permissionName);
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


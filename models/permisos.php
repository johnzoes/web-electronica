<?php
class Permisos {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function hasPermission($roleId, $permission) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM role_permission rp
                                    JOIN permisos p ON rp.id_permiso = p.id_permiso
                                    WHERE rp.id_rol = ? AND p.nombre = ?");
        $stmt->execute([$roleId, $permission]);
        return $stmt->fetchColumn() > 0;
    }
}


<?php
class PermissionManager {
    private $userRole;

    public function __construct($db) {
        $this->userRole = new UserRole($db);
    }

    public function canCreateItem($userId) {
        $roleId = $this->userRole->getRoleIdByUserId($userId);
        return ($roleId == 1 || $roleId == 2);
    }

    // Aquí puedes añadir más métodos para gestionar otros permisos
    public function canEditItem($userId) {
        $roleId = $this->userRole->getRoleIdByUserId($userId);
        return ($roleId == 1 || $roleId == 2); // Asumiendo que los roles 1 y 2 pueden editar
    }

    public function canDeleteItem($userId) {
        $roleId = $this->userRole->getRoleIdByUserId($userId);
        return ($roleId == 1); // Solo el rol 1 puede eliminar
    }
}


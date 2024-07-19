<?php
require_once 'models/userRole.php';
require_once 'models/permisos.php';


class AuthorizationMiddleware {
    private $userRole;
    private $permission;

    public function __construct($userRole, $permission) {
        $this->userRole = $userRole;
        $this->permission = $permission;
    }

    public function checkPermission($userId, $permission) {
        $roleId = $this->userRole->getRoleIdByUserId($userId);
        return $this->permission->hasPermission($roleId, $permission);
    }
}
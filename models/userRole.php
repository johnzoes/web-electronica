<?php
class UserRole {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getRoleIdByUserId($userId) {
        $stmt = $this->db->prepare("SELECT id_rol FROM usuario WHERE id_usuario = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }
}


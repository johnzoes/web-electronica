<?php
class Notification {
    private $db;
    public $user_id;
    public $message;
    public $is_read;
    public $id_reserva;

        public function __construct() {
            $this->db = connectDatabase();
        }

    public function save() {
        $query = "INSERT INTO notifications (user_id, message, is_read, id_reserva) VALUES (?, ?, ?, ?)";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param("isii", $this->user_id, $this->message, $this->is_read, $this->id_reserva);
            return $stmt->execute();
        }
        return false;
    }

    public static function getByUserId($user_id) {
        $db = connectDatabase();
        $query = "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
        if ($stmt = $db->prepare($query)) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    public static function countUnreadByUser($user_id) {
        $db = connectDatabase();
        $query = "SELECT COUNT(*) as unread_count FROM notifications WHERE user_id = ? AND is_read = 0";
        if ($stmt = $db->prepare($query)) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return $row['unread_count'];
        }
        return 0;
    }

    public static function markAsRead($id) {
        $db = connectDatabase();
        $query = "UPDATE notifications SET is_read = 1 WHERE id = ?";
        if ($stmt = $db->prepare($query)) {
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
        return false;
    }

    public static function find($id) {
        $db = connectDatabase();
        $query = "SELECT * FROM notifications WHERE id = ?";
        if ($stmt = $db->prepare($query)) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
        return null;
    }
}
<?php
class Notification {
    private $db;
    public $user_id;
    public $message;
    public $is_read;

    public function __construct() {
        $this->db = connectDatabase();
    }

    public function save() {
        $query = "INSERT INTO notifications (user_id, message, is_read) VALUES (?, ?, ?)";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param("isi", $this->user_id, $this->message, $this->is_read);
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
}
?>

<?php
require_once 'models/notificacion.php';

class NotificacionController {
    public function index() {
        $notificaciones = Notification::getByUserId($_SESSION['user_id']);
        error_log("Notificaciones obtenidas: " . print_r($notificaciones, true));
        $view = 'views/notificaciones/index.php';
        require_once 'views/layout.php';
    }    

    public function markAsRead() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            Notification::markAsRead($id);
        }
        header('Location: index.php?controller=notificacion&action=index');
        exit;
    }

    public function view($id) {
        Notification::markAsRead($id);
        $notificacion = Notification::find($id);

        if ($notificacion) {
            $reservaId = $notificacion['id_reserva'];
            header("Location: index.php?controller=reserva&action=showPDF&id=$reservaId");
            exit;
        }

        header('Location: index.php?controller=notificacion&action=index');
        exit;
    }


    // En tu NotificationController (o el controlador relevante)
    public function fetca() {
        // Asegúrate de que el usuario esté autenticado
        if (!isset($_SESSION['user_id'])) {
            header('HTTP/1.0 403 Forbidden');
            echo json_encode(['error' => 'User not authenticated']);
            exit;
        }
    
        // Obtén las notificaciones del usuario
        $userId = $_SESSION['user_id'];
        $notifications = Notification::getByUserId($userId);
    
        // Enviar respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode($notifications);
    }
    
public function fetchUnreadCount() {
    if (isset($_SESSION['user_id'])) {
        $unreadCount = Notification::countUnreadByUser($_SESSION['user_id']);
        echo json_encode(['unread_count' => $unreadCount]);
    } else {
        echo json_encode(['unread_count' => 0]);
    }
}

    
    

}
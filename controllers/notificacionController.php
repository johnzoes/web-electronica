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
public function fetch() {
    header('Content-Type: application/json');
    $user_id = $_SESSION['user_id'];
    $notificaciones = Notification::getByUserId($user_id);
    echo json_encode($notificaciones);
}

}
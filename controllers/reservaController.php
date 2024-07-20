<?php
require_once 'models/item.php';
require_once 'models/reserva.php';
require_once 'models/unidad_didactica.php';
require_once 'models/detalle_reserva_item.php';
require_once 'models/turno.php';
require_once 'models/estado_reserva.php';
require_once 'models/notification.php';


class ReservaController {

    public function index() {
        $rol = isset($_SESSION['role']) ? $_SESSION['role'] : null;
    
        if ($rol == 3) { // Si es profesor
            $view = 'views/reserva/index.php';
        } else {
            $reservas = Reserva::all();
            $view = 'views/reserva/admin_index.php'; // Cambia esta línea si tienes una vista específica para administradores
        }
    
        require_once 'views/layout.php';
    }

    public function mis_reservas() {
        $reservas = Reserva::findByProfesor($_SESSION['user_id']);
        $view = 'views/reserva/mis_reservas.php';
        require_once 'views/layout.php';
    }    

    public function show($id) {
        $reserva = Reserva::find($id);
        $view = 'views/reserva/show.php';
        require_once 'views/layout.php';
    }

    public function create() {
        $items = Item::all();
        $unidades_didactica = UnidadDidactica::all();
        $profesores = Profesor::all(); // Aquí estamos obteniendo todos los profesores
        $turnos = Turno::all();
        
        $view = 'views/reserva/create.php';
        require_once 'views/layout.php';
    }
    

    public function store() {
        if ($_SESSION['role'] != 3) {
            header('Location: index.php?controller=reserva&action=index');
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['item']) && isset($_POST['fecha_prestamo']) && isset($_POST['unidad_didactica']) && isset($_POST['id_profesor']) && isset($_POST['id_turno'])) {
            $selectedItems = $_POST['item'];
    
            $data = [
                'fecha_prestamo' => $_POST['fecha_prestamo'],
                'id_unidad_didactica' => $_POST['unidad_didactica'],
                'id_profesor' => $_POST['id_profesor'],
                'id_turno' => $_POST['id_turno'],
            ];
    
            // Crear la reserva
            $reservaId = Reserva::create($data);
            $fecha_reserva = date('Y-m-d');
            $hora_reserva = date('H:i:s');
    
            if ($reservaId) {
                foreach ($selectedItems as $itemId) {
                    // Crear un nuevo detalle_reserva_item para cada item seleccionado
                    DetalleReservaItem::create([
                        'id_reserva' => $reservaId,
                        'id_item' => $itemId,
                        'fecha_reserva' => $fecha_reserva,
                        'hora_reserva' => $hora_reserva,
                    ]);
                }
    
                // Crear el estado de reserva (pendiente)
                EstadoReserva::create([
                    'id_reserva' => $reservaId,
                    'estado' => 'Pendiente',
                    'motivo_rechazo' => '',
                    'fecha_estado' => $fecha_reserva,
                    'hora_estado' => $hora_reserva,
                ]);


                $reservation = new Reserva();
                $reservation->user_id = $_SESSION['user_id'];
                $reservation->salon_id = $_POST['salon_id'];
                $reservation->item_id = $_POST['item_id'];
                $reservation->cantidad = $_POST['cantidad'];
                $reservation->estado = 'pending';
        
                if ($reservation->save()) {
                    $this->notifyAssistants($reservation);
                    header('Location: index.php?controller=reserva&action=index&status=success');
                } else {
                    header('Location: index.php?controller=reserva&action=create&status=error');
                }
    
                header('Location: index.php?controller=reserva&action=mis_reservas');
                exit;
            } else {
                echo "Error al crear la reserva.";
            }
        } else {
            echo "Error: Datos POST incompletos o incorrectos.";
        }
    }

    public function edit($id) {
        if ($_SESSION['role'] != 3) {
            header('Location: index.php?controller=reserva&action=index');
            exit;
        }

        $reserva = Reserva::find($id);
        $view = 'views/reserva/edit.php';
        require_once 'views/layout.php';
    }

    public function update($id) {
        if ($_SESSION['role'] != 3) {
            header('Location: index.php?controller=reserva&action=index');
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                'fecha_reserva' => $_POST['fecha_reserva'],
                'fecha_prestamo' => $_POST['fecha_prestamo'],
                'hora_reserva' => $_POST['hora_reserva'],
                'id_profesor' => $_POST['id_profesor'],
            ];
            Reserva::update($id, $data);
            header('Location: index.php?controller=reserva&action=mis_reservas');
            exit;
        }
    }

    public function delete($id) {
        if ($_SESSION['role'] != 3) {
            header('Location: index.php?controller=reserva&action=index');
            exit;
        }

        Reserva::delete($id);
        header('Location: index.php?controller=reserva&action=mis_reservas');
        exit;
    }

    public function obtener_unidad_didactica() {
        header('Content-Type: application/json');
        if (isset($_GET['ciclo'])) {
            $ciclo = $_GET['ciclo'];
            $unidades = UnidadDidactica::findUnidadDidacticaByCiclo($ciclo);
            if ($unidades !== false) {
                echo json_encode($unidades);
            } else {
                echo json_encode([]);
            }
        } else {
            echo json_encode([]);
        }
    }


    private function notifyAssistants($reservation) {
        $salon = new Salon();
        $assistants = $salon->getAssistantsBySalonId($reservation->salon_id);
        foreach ($assistants as $assistant) {
            $notification = new Notification();
            $notification->user_id = $assistant['id_usuario'];
            $notification->message = "Nueva reserva creada por el profesor " . $_SESSION['username'];
            $notification->is_read = false;
            $notification->save();
        }
    }

}
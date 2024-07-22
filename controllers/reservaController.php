<?php
require_once 'models/item.php';
require_once 'models/reserva.php';
require_once 'models/unidad_didactica.php';
require_once 'models/detalle_reserva_item.php';
require_once 'models/turno.php';
require_once 'models/estado_reserva.php';
require_once 'models/notificacion.php';
require_once 'models/usuario.php';
require_once 'fpdf/fpdf.php';
require_once 'models/asistente.php';

class ReservaController {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function index() {
        $rol = isset($_SESSION['role']) ? $_SESSION['role'] : null;
    
        // Obtener notificaciones no leídas
        $notificaciones_no_leidas = Notification::countUnreadByUser($_SESSION['user_id']);
        $notificaciones = Notification::getByUserId($_SESSION['user_id']);
    
        if ($rol == 3) { // Si es profesor
            $view = 'views/reserva/index.php';
        } else {
            $reservas = Reserva::allWithDetails();
            $view = 'views/reserva/admin_index.php';
        }
    
        require_once 'views/layout.php';
    }     

    public function mis_reservas() {
        $stmt = $this->conexion->prepare("SELECT id_profesor FROM profesor WHERE id_usuario = ?");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $profesor = $result->fetch_assoc();
    
        if (!$profesor) {
            echo "Error: Profesor no encontrado.";
            return;
        }
    
        $reservas = Reserva::findByProfesor($profesor['id_profesor']);
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
        $turnos = Turno::all();

        $view = 'views/reserva/create.php';
        require_once 'views/layout.php';
    }
    

    public function store() {
        if ($_SESSION['role'] != 3) {
            header('Location: index.php?controller=reserva&action=index');
            exit;
        }
    
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['item']) && isset($_POST['fecha_prestamo']) && isset($_POST['unidad_didactica']) && isset($_POST['id_turno'])) {
            $selectedItems = $_POST['item'];
    
            // Obtener id_profesor y nombre del profesor de la tabla profesor usando id_usuario de la sesión
            $stmt = $this->conexion->prepare("SELECT p.id_profesor, u.nombre, u.apellidos FROM profesor p JOIN usuario u ON p.id_usuario = u.id_usuario WHERE p.id_usuario = ?");
            $stmt->bind_param("i", $_SESSION['user_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $profesor = $result->fetch_assoc();
    
            if (!$profesor) {
                echo "Error: Profesor no encontrado.";
                return;
            }
    
            $data = [
                'fecha_prestamo' => $_POST['fecha_prestamo'],
                'id_unidad_didactica' => $_POST['unidad_didactica'],
                'id_profesor' => $profesor['id_profesor'], // Utilizar el id_profesor obtenido
                'id_turno' => $_POST['id_turno'],
            ];
    
            $reservaId = Reserva::create($data);
            $fecha_reserva = date('Y-m-d');
            $hora_reserva = date('H:i:s');
    
            if ($reservaId) {
                foreach ($selectedItems as $itemId) {
                    $id_salon = Salon::getIdSalonbyIdItem($itemId);
                    DetalleReservaItem::create([
                        'id_reserva' => $reservaId,
                        'id_item' => $itemId,
                        'fecha_reserva' => $fecha_reserva,
                        'hora_reserva' => $hora_reserva,
                    ]);
                }
    
                EstadoReserva::create([
                    'id_reserva' => $reservaId,
                    'estado' => 'pendiente',
                    'motivo_rechazo' => '',
                ]);
    
                // Crear notificación para todos los asistentes
                $estado_reserva = 'pendiente';
                $message = "Reserva $estado_reserva creada por el profesor " . $profesor['nombre'] . " " . $profesor['apellidos'];
    
                $stmt = $this->conexion->prepare("SELECT id_usuario FROM asistente");
                $stmt->execute();
                $result = $stmt->get_result();
                $assistants = $result->fetch_all(MYSQLI_ASSOC);
    
                foreach ($assistants as $assistant) {
                    $notification = new Notification();
                    $notification->user_id = $assistant['id_usuario'];
                    $notification->message = $message;
                    $notification->is_read = 0;
                    $notification->id_reserva = $reservaId;
                    $notification->save();
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

    public function showPDF($id) {
        $reserva = Reserva::findWithDetails($id);
    
        if (!$reserva) {
            echo "Reserva no encontrada.";
            return;
        }
    
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
    
        $pdf->Cell(40, 10, utf8_decode('Detalles de la Reserva'));
        $pdf->Ln();
        $pdf->Cell(40, 10, utf8_decode('ID: ' . $reserva['id_reserva']));
        $pdf->Ln();
        $pdf->Cell(40, 10, utf8_decode('Fecha de Prestamo: ' . $reserva['fecha_prestamo']));
        $pdf->Ln();
        $pdf->Cell(40, 10, utf8_decode('Unidad Didactica: ' . $reserva['nombre_unidad_didactica']));
        $pdf->Ln();
        $pdf->Cell(40, 10, utf8_decode('Turno: ' . $reserva['nombre_turno']));
        $pdf->Ln();
        $pdf->Cell(40, 10, utf8_decode('Profesor: ' . $reserva['nombre_profesor']));
    
        $pdf->Output('I', 'reserva_' . $reserva['id_reserva'] . '.pdf');
    }             

    public function downloadPDF($id) {
        $reserva = Reserva::findWithDetails($id);
    
        if (!$reserva) {
            echo "Reserva no encontrada.";
            return;
        }
    
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
    
        // Agrega contenido al PDF
        $pdf->Cell(40, 10, utf8_decode('Detalles de la Reserva'));
        $pdf->Ln();
        $pdf->Cell(40, 10, utf8_decode('ID: ' . $reserva['id_reserva']));
        $pdf->Ln();
        $pdf->Cell(40, 10, utf8_decode('Fecha de Prestamo: ' . $reserva['fecha_prestamo']));
        $pdf->Ln();
        $pdf->Cell(40, 10, utf8_decode('Unidad Didactica: ' . $reserva['nombre_unidad_didactica']));
        $pdf->Ln();
        $pdf->Cell(40, 10, utf8_decode('Turno: ' . $reserva['nombre_turno']));
        $pdf->Ln();
        $pdf->Cell(40, 10, utf8_decode('Profesor: ' . $reserva['nombre_profesor']));
    
        $pdf->Output('D', 'reserva_' . $reserva['id_reserva'] . '.pdf');
    }
}
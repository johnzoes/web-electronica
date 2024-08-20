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

        //LOGICA PARA OBTENER TODOS LOS DATOS DE LOS DETALLES DE RESERVA
        $asistentes = Asistente::all();
        $datos_asistente = [];
        foreach ($asistentes as $asistente) {
            $usuario = Usuario::find($asistente['id_usuario']);
            if ($usuario) {
                $turno = Turno::find($asistente['id_turno']);
                $salon = Salon::find($asistente['id_salon']);
                $datos_asistente[] = [
                    'id_usuario' => $asistente['id_usuario'],
                    'id_asistente' => $asistente['id_asistente'],
                    'nombre_usuario' => $usuario['nombre_usuario'],
                    'nombre' => $usuario['nombre'],
                    'apellidos' => $usuario['apellidos'],
                    'nombre_turno' => $turno['nombre'],
                    'id_salon' => $salon['nombre_salon']
                ];
            }
        }
        $reservas_pendientes = Reserva::allWithDetails();


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
            echo 'Redirección por rol incorrecto.<br>';
            header('Location: index.php?controller=reserva&action=index');
            exit;
        }
    
        echo 'Datos POST: ';
        print_r($_POST);
        echo '<br>';
    
        echo 'Variables de sesión: ';
        print_r($_SESSION);
        echo '<br>';


        /* se obtienen los datos para la reserva */
    
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['item']) && isset($_POST['fecha_prestamo']) && isset($_POST['unidad_didactica']) && isset($_POST['id_turno'])) {
            $selectedItems = $_POST['item'];
    
            echo 'POST validado correctamente.<br>';
    
            // Obtener id_profesor y nombre del profesor de la tabla profesor usando id_usuario de la sesión
            $stmt = $this->conexion->prepare("SELECT p.id_profesor, u.nombre, u.apellidos FROM profesor p JOIN usuario u ON p.id_usuario = u.id_usuario WHERE p.id_usuario = ?");
            if (!$stmt) {
                echo "Error preparando la consulta: " . $this->conexion->error . "<br>";
                exit;
            }
            $stmt->bind_param("i", $_SESSION['user_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $profesor = $result->fetch_assoc();
    
            if (!$profesor) {
                echo "Error: Profesor no encontrado.<br>";
                exit;
            }
    
            $data = [
                'fecha_prestamo' => $_POST['fecha_prestamo'],
                'id_unidad_didactica' => $_POST['unidad_didactica'],
                'id_profesor' => $profesor['id_profesor'], // Utilizar el id_profesor obtenido
                'id_turno' => $_POST['id_turno'],
            ];
    
            echo 'Datos para crear reserva: ';
            print_r($data);
            echo '<br>';
    
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
    
                // Crear notificación para los asistentes encargados del id_salon y turno
                $estado_reserva = 'pendiente';
                $message = $reservaId. " Reserva $estado_reserva creada por el profesor " . $profesor['nombre'] . " " . $profesor['apellidos'];
    
                $stmt = $this->conexion->prepare("SELECT id_usuario FROM asistente WHERE id_salon = ? AND id_turno = ?");
                foreach ($selectedItems as $itemId) {
                    $id_salon = Salon::getIdSalonbyIdItem($itemId);
                    if (!$stmt) {
                        echo "Error preparando la consulta: " . $this->conexion->error . "<br>";
                        exit;
                    }
                    $stmt->bind_param("ii", $id_salon, $_POST['id_turno']);
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
                }
    
                echo 'Redirección exitosa.<br>';
                header('Location: index.php?controller=reserva&action=mis_reservas');
                exit;
            } else {
                echo "Error al crear la reserva.<br>";
                exit;
            }
        } else {
            echo 'Error: Datos POST incompletos o incorrectos.<br>';
            exit;
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
        $itemsReserva = Item::getItemsByIdReserva($id);
        $reserva = Reserva::findWithDetails($id);
    
        if (!$reserva) {
            echo "Reserva no encontrada.";
            return;
        }
    
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
    
        // Título de la reserva
        $pdf->Cell(0, 10, utf8_decode('Detalles de la Reserva'), 0, 1, 'C');
        $pdf->Ln(10);
    
        // Detalles de la reserva
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, utf8_decode('ID: ') . $reserva['id_reserva']);
        $pdf->Ln();
        $pdf->Cell(0, 10, utf8_decode('Fecha de Préstamo: ') . $reserva['fecha_prestamo']);
        $pdf->Ln();
        $pdf->Cell(0, 10, utf8_decode('Unidad Didáctica: ') . utf8_decode($reserva['nombre_unidad_didactica']));
        $pdf->Ln();
        $pdf->Cell(0, 10, utf8_decode('Turno: ') . utf8_decode($reserva['nombre_turno']));
        $pdf->Ln();
        $pdf->Cell(0, 10, utf8_decode('Profesor: ') . utf8_decode($reserva['nombre_profesor']));
        $pdf->Ln(10);
    
        // Encabezado de la tabla
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(30, 10, utf8_decode('Código BCI'), 1);
        $pdf->Cell(60, 10, utf8_decode('Descripción'), 1);
       /* $pdf->Cell(20, 10, utf8_decode('Cantidad'), 1);
        $pdf->Cell(30, 10, utf8_decode('Estado'), 1);
        $pdf->Cell(30, 10, utf8_decode('Marca'), 1);*/
        $pdf->Cell(30, 10, utf8_decode('Modelo'), 1);
        $pdf->Ln();
    
        // Datos de los items
        $pdf->SetFont('Arial', '', 12);
        foreach ($itemsReserva as $item) {
            $pdf->Cell(30, 10, $item['codigo_bci'], 1);
            $pdf->Cell(60, 10, utf8_decode($item['descripcion']), 1);
          /*  $pdf->Cell(20, 10, $item['cantidad'], 1);
            $pdf->Cell(30, 10, utf8_decode($item['estado']), 1);
            $pdf->Cell(30, 10, utf8_decode($item['marca']), 1);*/
            $pdf->Cell(30, 10, utf8_decode($item['modelo']), 1);
            $pdf->Ln();
        }
    
        // Salida del PDF
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
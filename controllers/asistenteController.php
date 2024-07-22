<?php
require_once 'models/asistente.php';
require_once 'models/usuario.php';
require_once 'models/turno.php';
require_once 'models/salon.php';
require_once 'models/reserva.php';
require_once 'models/estado_reserva.php';
require_once 'models/notificacion.php';

class AsistenteController {

    public function index() {
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
        $view = 'views/asistente/index.php';
        require_once 'views/layout.php';
    }

    public function show($id) {
        $profesor = Asistente::find($id);
        $view = 'views/asistente/show.php';
        require_once 'views/layout.php';
    }

    public function create() {
        $view = 'views/asistente/create.php';
        require_once 'views/layout.php';
    }

    public function store() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                'nombre' => $_POST['nombre']
            ];
            Asistente::create($data);
            header('Location: index.php?controller=asistente&action=index');
            exit;
        }
    }

    public function edit($id) {
        $usuario = Usuario::find($id);
        $asistente = Asistente::findAsistenteByUsuarioId($usuario['id_usuario']); 
        $turnos = Turno::all();
        $salones = Salon::all();
        $view = 'views/asistente/edit.php';
        require_once 'views/layout.php';
    }

    public function update($id) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data_usuario = [
                'nombre_usuario' => $_POST['nombre_usuario'],
                'nombre' => $_POST['nombre'],
                'apellidos' => $_POST['apellidos']
            ];

            $data_asistente = [
                'id_salon' => $_POST['id_salon'],
                'id_turno' => $_POST['id_turno']
            ];

            Usuario::update($id, $data_usuario);
            Asistente::updateByUsuarioId($id, $data_asistente);
            header('Location: index.php?controller=asistente&action=index');
            exit;
        }
    }

    public function delete($id) {
        Asistente::deleteByUsuarioId($id);
        header('Location: index.php?controller=asistente&action=index');
        exit;
    }

    public function aceptar_reserva($id_reserva) {
        EstadoReserva::updateByReservaId($id_reserva, [
            'estado' => 'aceptado',
            'motivo_rechazo' => '',
        ]);
    
        $reserva = Reserva::find($id_reserva);
        $profesor = Profesor::find($reserva['id_profesor']);
        $usuario = Usuario::find($profesor['id_usuario']);
    
        // Crear notificación para el profesor
        $notification = new Notification();
        $notification->user_id = $usuario['id_usuario'];
        $notification->message = "Tu reserva con ID $id_reserva ha sido aceptada.";
        $notification->is_read = 0;
        $notification->save();
    
        header('Location: index.php?controller=asistente&action=index');
        exit;
    }      
}
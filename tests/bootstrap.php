<?php

require_once __DIR__ . '/../models/database.php';

$GLOBALS['conexion'] = connectDatabase();

require_once __DIR__ . '/../models/item.php';
require_once __DIR__ . '/../models/reserva.php';
require_once __DIR__ . '/../models/estado_reserva.php';
require_once __DIR__ . '/../models/notificacion.php';
require_once __DIR__ . '/../models/profesor.php';
require_once __DIR__ . '/../models/asistente.php';
require_once __DIR__ . '/../models/unidad_didactica.php';
require_once __DIR__ . '/../models/detalle_reserva_item.php';
require_once __DIR__ . '/../models/turno.php';
require_once __DIR__ . '/../middleware/AuthorizationMiddleware.php';
require_once __DIR__ . '/../controllers/ItemController.php';
require_once __DIR__ . '/../controllers/ReservaController.php';

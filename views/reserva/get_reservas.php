<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'models/Reserva.php';

$reserva = new Reserva();

// Verificar el tipo de solicitud
$type = isset($_GET['type']) ? $_GET['type'] : 'pendientes';

// Verificar si hay algún error con el tipo
if (!in_array($type, ['pendientes', 'historial', 'rechazadas'])) {
    echo json_encode(['error' => 'Tipo de solicitud no válido']);
    exit;
}

// Obtener las reservas según el tipo
if ($type === 'pendientes') {
    $reservas = $reserva->getReservasPendientes();
} elseif ($type === 'historial') {
    $reservas = $reserva->getHistorialReservas();
} elseif ($type === 'rechazadas') {
    $reservas = $reserva->getReservasRechazadas();
}

// Verificar si se obtuvieron reservas
if (empty($reservas)) {
    echo json_encode(['error' => 'No se encontraron reservas']);
    exit;
}

// Devolver los datos como JSON
header('Content-Type: application/json');
echo json_encode($reservas);

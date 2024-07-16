<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'db_electronica');

/**
 * Establece la conexión a la base de datos.
 *
 * @return mysqli
 * @throws Exception
 */
function connectDatabase() {
    $conexion = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conexion->connect_error) {
        throw new Exception("Conexión fallida: " . $conexion->connect_error);
    }

    return $conexion;
}

try {
    $conexion = connectDatabase();
} catch (Exception $e) {
    die($e->getMessage());
}

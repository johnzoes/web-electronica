<?php

use PHPUnit\Framework\TestCase;

class ReservaControllerTest extends TestCase {
    protected $controller;

    protected function setUp(): void {
        global $conexion;
        $this->controller = new ReservaController($conexion);
        $_SESSION['role'] = 3; // Asegúrate de que el rol del usuario está establecido
        $_SESSION['user_id'] = 1; // Establece un user_id para las pruebas
    }

    public function testStoreReserva() {
        $_POST = [
            'item' => [1, 2],
            'fecha_prestamo' => '2024-07-22',
            'unidad_didactica' => 1,
            'id_turno' => 1
        ];

        // Limpia las cabeceras previas
        if (function_exists('xdebug_get_headers')) {
            xdebug_get_headers();
        }

        ob_start();
        $this->controller->store();
        ob_end_clean();

        // Imprime todas las cabeceras para depuración
        $headers = headers_list();
        foreach ($headers as $header) {
            echo $header . "\n";
        }

        $found = false;
        foreach ($headers as $header) {
            if (strpos($header, 'Location: index.php?controller=reserva&action=mis_reservas') !== false) {
                $found = true;
                break;
            }
        }

        $this->assertTrue($found, 'Expected header not found in: ' . print_r($headers, true));
    }
}

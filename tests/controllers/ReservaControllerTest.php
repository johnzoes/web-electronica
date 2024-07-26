<?php

use PHPUnit\Framework\TestCase;

class ReservaControllerTest extends TestCase {
    protected $controller;

    protected function setUp(): void {
        global $conexion;
        $this->controller = new ReservaController($conexion);
        $_SESSION['role'] = 3; // Asegúrate de que el rol del usuario está establecido
        $_SESSION['user_id'] = 1; // Establece un user_id para las pruebas, asegurándote que este id exista en `profesor`
    }

    public function testStoreReserva() {
        $_POST = [
            'item' => [1, 2],
            'fecha_prestamo' => '2024-07-22',
            'unidad_didactica' => 1,
            'id_turno' => 1
        ];

        ob_start();
        $this->controller->store();
        $output = ob_get_clean();
        
        // Depuración
        echo "Datos POST en prueba: ";
        print_r($_POST);
        echo "<br>Variables de sesión en prueba: ";
        print_r($_SESSION);
        echo "<br>Output: $output<br>";

        $this->assertEquals('redirect:index.php?controller=reserva&action=mis_reservas', $output, "Error: No se redirigió correctamente.");
    }
}

<?php

use PHPUnit\Framework\TestCase;

class ReservaTest extends TestCase {
    public function setUp(): void {
        Reserva::init();
    }

    public function testCreateReserva() {
        $data = [
            'fecha_prestamo' => '2024-12-01',
            'id_profesor' => 1,
            'id_unidad_didactica' => 1,
            'id_turno' => 1
        ];

        $result = Reserva::create($data);
        $this->assertIsInt($result);
    }

    public function testUpdateReserva() {
        $data = [
            'fecha_prestamo' => '2024-12-02',
            'id_profesor' => 1,
            'id_unidad_didactica' => 1,
            'id_turno' => 1,
            'items' => [
                1 => 2, // Item ID => Cantidad
                2 => 1
            ]
        ];

        $result = Reserva::update(1, $data); // Asumiendo que la reserva con ID 1 existe
        $this->assertTrue($result);
    }
}

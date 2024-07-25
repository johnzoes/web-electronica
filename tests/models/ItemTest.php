<?php

use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase {
    protected function setUp(): void {
        global $conexion;
        Item::setConexion($conexion);
    }

    public function testCreateUniqueItem() {
        $data = [
            'codigo_bci' => 'UNQ123',
            'descripcion' => 'Unique Item',
            'cantidad' => 1,
            'estado' => 'Disponible',
            'marca' => 'MarcaX',
            'modelo' => 'ModeloX',
            'imagen' => 'imagen.jpg',
            'id_ubicacion' => 1,
            'nro_inventariado' => 'INV-001',
            'id_categoria' => 1
        ];
        $this->assertTrue(Item::create($data));
    }

    public function testCreateNonUniqueItem() {
        $data = [
            'codigo_bci' => 'NON123',
            'descripcion' => 'Non-Unique Item',
            'cantidad' => 10,
            'estado' => 'Disponible',
            'marca' => 'MarcaY',
            'modelo' => 'ModeloY',
            'imagen' => 'imagen.jpg',
            'id_ubicacion' => 1,
            'nro_inventariado' => 'INV-002',
            'id_categoria' => 2
        ];
        $this->assertTrue(Item::create($data));
    }
}

<?php

use PHPUnit\Framework\TestCase;

class ItemControllerTest extends TestCase {
    public function testStoreUniqueItem() {
        $_POST = [
            'codigo_bci' => 'U12345',
            'descripcion' => 'Item Único de Prueba',
            'cantidad' => 1,
            'estado' => 'Disponible',
            'marca' => 'MarcaTest',
            'modelo' => 'ModeloTest',
            'id_armario' => 1,
            'nro_inventariado' => 'INV-TEST',
            'id_categoria' => 1,
            'es_unico' => 1
        ];
        $_FILES['imagen'] = [
            'name' => 'imagen.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => __DIR__ . '/imagen.jpg',
            'error' => 0,
            'size' => 123
        ];

        $controller = new ItemController(new AuthorizationMiddleware(new UserRole($GLOBALS['conexion']), new Permission($GLOBALS['conexion'])));
        $controller->store();

        $this->expectOutputString(''); // Verificar que no haya output
    }

    public function testStoreNonUniqueItem() {
        $_POST = [
            'codigo_bci' => 'NU12345',
            'descripcion' => 'Item No Único de Prueba',
            'cantidad' => 10,
            'estado' => 'Disponible',
            'marca' => 'MarcaTest',
            'modelo' => 'ModeloTest',
            'id_armario' => 1,
            'nro_inventariado' => 'INV-TEST',
            'id_categoria' => 1,
            'es_unico' => 0
        ];
        $_FILES['imagen'] = [
            'name' => 'imagen.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => __DIR__ . '/imagen.jpg',
            'error' => 0,
            'size' => 123
        ];

        $controller = new ItemController(new AuthorizationMiddleware(new UserRole($GLOBALS['conexion']), new Permission($GLOBALS['conexion'])));
        $controller->store();

        $this->expectOutputString(''); // Verificar que no haya output
    }
}

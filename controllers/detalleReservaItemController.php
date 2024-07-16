<?php
require_once 'models/detalle_reserva_item.php';

class DetalleReservaItemController {

    public function index() {
        $detalles = DetalleReservaItem::all();
        $view = 'views/detalle_reserva_item/index.php';
        require_once 'views/layout.php';
    }

    public function show($id) {
        $detalle = DetalleReservaItem::find($id);
        $view = 'views/detalle_reserva_item/show.php';
        require_once 'views/layout.php';
    }

    public function create() {
        $view = 'views/detalle_reserva_item/create.php';
        require_once 'views/layout.php';
    }

    public function store() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                'id_reserva' => $_POST['id_reserva'],
                'id_item' => $_POST['id_item']
            ];
            DetalleReservaItem::create($data);
            header('Location: index.php?controller=detalleReservaItem&action=index');
            exit;
        }
    }

    public function edit($id) {
        $detalle = DetalleReservaItem::find($id);
        $view = 'views/detalle_reserva_item/edit.php';
        require_once 'views/layout.php';
    }

    public function update($id) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                'id_reserva' => $_POST['id_reserva'],
                'id_item' => $_POST['id_item']
            ];
            DetalleReservaItem::update($id, $data);
            header('Location: index.php?controller=detalleReservaItem&action=index');
            exit;
        }
    }

    public function delete($id) {
        DetalleReservaItem::delete($id);
        header('Location: index.php?controller=detalleReservaItem&action=index');
        exit;
    }
}


<?php
require_once '../model/Gaseosa.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $marca = $_POST['marca'];
    $precioUnidad = $_POST['precio_unidad'];
    $precioPaquete = $_POST['precio_paquete'];
    $stockUnidades = $_POST['stock_unidades'];
    $stockPaquetes = $_POST['stock_paquetes'];

    try {
        // Instancia del modelo
        $gaseosaModel = new Gaseosa();
        $resultado = $gaseosaModel->actualizarGaseosa($id, $nombre, $marca, $precioUnidad, $precioPaquete, $stockUnidades, $stockPaquetes);

        if ($resultado) {
            header("Location: ../view/listarGaseosas.php?mensaje=actualizado");
            exit();
        } else {
            header("Location: ../view/listarGaseosas.php?mensaje=error");
            exit();
        }
    } catch (Exception $e) {
        header("Location: ../view/listarGaseosas.php?mensaje=error&error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: ../view/listarGaseosas.php");
    exit();
}

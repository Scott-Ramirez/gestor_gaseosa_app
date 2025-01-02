<?php
require_once '../controller/GaseosaController.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $gaseosaController = new GaseosaController();
    $resultado = $gaseosaController->eliminarGaseosa($id);
    
    // Redirigir con el estado de la operación
    header('Location: ../view/listarGaseosas.php?status=' . ($resultado ? 'success' : 'error'));
    exit;
} else {
    header('Location: ../view/listarGaseosas.php?status=error');
    exit;
}

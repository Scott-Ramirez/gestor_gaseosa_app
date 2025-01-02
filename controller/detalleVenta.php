<?php
require_once '../model/Venta.php';

header('Content-Type: application/json');

try {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $ventaId = intval($_GET['id']);
        $ventaModel = new Venta();

        // Obtener la venta por ID
        $venta = $ventaModel->obtenerVentaPorId($ventaId);

        // Obtener los detalles de la venta
        $detalles = $ventaModel->obtenerDetallePorId($ventaId);

        if ($venta) {
            echo json_encode([
                'fecha' => $venta['fecha_venta'],
                'hora' => date('H:i:s', strtotime($venta['fecha_venta'])), // Formatear la hora
                'monto' => $venta['total_venta'],
                'productos' => $detalles
            ]);
        } else {
            echo json_encode(['error' => 'No se encontró la venta.']);
        }
    } else {
        echo json_encode(['error' => 'Solicitud inválida.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Error interno del servidor: ' . $e->getMessage()]);
}

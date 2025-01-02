<?php
require_once '../model/Venta.php';

// Agregar log inicial
error_log("Iniciando proceso de cierre de caja");

// Inicializar el modelo
$ventaModel = new Venta();

// Obtener las ventas del día
$ventasDelDia = $ventaModel->listarVentasDelDia();

// Agregar log para verificar las ventas
error_log("Ventas del día encontradas: " . count($ventasDelDia));

// Calcular el total de ventas
$totalVentas = 0;
foreach ($ventasDelDia as $venta) {
    $totalVentas += $venta['total_venta'];
}

// Log del total calculado
error_log("Total de ventas calculado: " . $totalVentas);

// Registrar el cierre de caja en la base de datos
try {
    $fecha_actual = date('Y-m-d H:i:s');
    
    // Log antes de intentar registrar
    error_log("Intentando registrar cierre de caja con fecha: " . $fecha_actual . " y total: " . $totalVentas);
    
    // Registrar el cierre de caja
    $cierreRegistrado = $ventaModel->registrarCierreCaja($fecha_actual);
    if ($cierreRegistrado) {
        error_log("Cierre de caja registrado exitosamente");

        // Mover las ventas del día al historial
        $ventasMovidas = $ventaModel->moverVentasAHistorial($fecha_actual);
        if ($ventasMovidas) {
            error_log("Ventas del día movidas al historial exitosamente");
        } else {
            error_log("Error al mover las ventas del día al historial");
        }

        // Redirigir al usuario a la vista de ventas con mensaje de éxito
        header("Location: ../view/verVentas.php?mensaje=exito&caja=cerrada");
        exit();
    } else {
        error_log("Fallo al registrar el cierre de caja");
        // Redirigir al usuario con un mensaje de error
        header("Location: ../view/verVentas.php?mensaje=error");
        exit();
    }
} catch (Exception $e) {
    error_log("Excepción al registrar el cierre de caja: " . $e->getMessage());
    // En caso de excepciones, redirigir con mensaje de error
    header("Location: ../view/verVentas.php?mensaje=error");
    exit();
}
?>

<?php
require_once '../model/Venta.php';
require_once '../model/DetalleVenta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'registrarVenta':
            try {
                // Iniciar transacción
                $venta = new Venta();
                $conexion = new Conexion();
                $conn = $conexion->conectar();
                $conn->beginTransaction();

                $fechaVenta = $_POST['fecha_venta'];
                $totalVenta = $_POST['total_venta'];
                $idGaseosas = $_POST['id_gaseosa'];
                $cantidadesUnidades = $_POST['cantidad_unidades'];
                $cantidadesPaquetes = $_POST['cantidad_paquetes'];

                // Registrar la venta
                $ventaId = $venta->registrarVenta($fechaVenta, $totalVenta);

                if (!$ventaId) {
                    throw new Exception("Error al registrar la venta");
                }

                // Registrar los detalles
                $detalleVenta = new DetalleVenta();
                foreach ($idGaseosas as $index => $idGaseosa) {
                    if (!$detalleVenta->registrarDetalle(
                        $ventaId,
                        $idGaseosa,
                        $cantidadesUnidades[$index],
                        $cantidadesPaquetes[$index]
                    )) {
                        throw new Exception("Error al registrar el detalle de la venta");
                    }
                }

                // Confirmar transacción
                $conn->commit();
                
                header("Location: ../view/registrarVenta.php?status=success");
                exit;

            } catch (Exception $e) {
                if(isset($conn)) {
                    $conn->rollBack();
                }
                header("Location: ../view/registrarVenta.php?error=" . urlencode($e->getMessage()));
                exit;
            }
            break;
    }
}

<?php
require_once 'Conexion.php';

class Venta
{
    private $conn;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->conn = $conexion->conectar();
    }

    // Método para registrar una nueva venta
    public function registrarVenta($fechaVenta, $totalVenta)
    {
        try {
            $query = "INSERT INTO ventas (fecha_venta, total_venta) VALUES (:fecha_venta, :total_venta)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':fecha_venta', $fechaVenta);
            $stmt->bindParam(':total_venta', $totalVenta);
            $stmt->execute();

            // Retorna el ID de la venta recién registrada
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error al registrar venta: " . $e->getMessage());
            return false;
        }
    }

    // Método para listar todas las ventas
    public function listarVentas()
    {
        try {
            $query = "SELECT * FROM ventas ORDER BY fecha_venta DESC";
            $stmt = $this->conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al listar ventas: " . $e->getMessage());
            return [];
        }
    }

    // Método para listar las ventas del día actual
    public function listarVentasDelDia()
    {
        try {
            $fecha_actual = date('Y-m-d');
            $query = "SELECT * FROM ventas WHERE DATE(fecha_venta) = :fecha ORDER BY fecha_venta DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':fecha', $fecha_actual);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al listar ventas del día: " . $e->getMessage());
            return [];
        }
    }

    // Método para registrar el cierre de caja del día
    public function registrarCierreCaja($fecha_cierre)
    {
        try {
            $query = "INSERT INTO caja_diaria (fecha_apertura, fecha_cierre, estado)
                      VALUES (CURRENT_TIMESTAMP, :fecha_cierre, 'Cerrado')";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':fecha_cierre', $fecha_cierre);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al registrar cierre de caja: " . $e->getMessage());
            return false;
        }
    }

    // Método para mover las ventas del día al historial
    public function moverVentasAHistorial($fecha_cierre)
    {
        try {
            // Contar las ventas del día 
            $queryContar = "SELECT COUNT(*) FROM ventas WHERE DATE(fecha_venta) = CURRENT_DATE";
            $stmtContar = $this->conn->query($queryContar);
            $count = $stmtContar->fetchColumn();
            error_log("Ventas encontradas para mover: " . $count);

            // Mover las ventas del día al historial_ventas
            $queryMover = "INSERT INTO historial_ventas (id_venta, fecha_venta, total_venta, fecha_cierre)
                           SELECT id_venta, fecha_venta, total_venta, :fecha_cierre
                           FROM ventas
                           WHERE DATE(fecha_venta) = CURRENT_DATE";
            $stmtMover = $this->conn->prepare($queryMover);
            $stmtMover->bindParam(':fecha_cierre', $fecha_cierre);
            $resultadoMover = $stmtMover->execute();

            if ($resultadoMover) {
                error_log("Ventas movidas al historial exitosamente.");
            } else {
                error_log("No se pudieron mover las ventas al historial.");
            }

            // Eliminar las ventas movidas al historial
            $queryEliminar = "DELETE FROM ventas WHERE DATE(fecha_venta) = CURRENT_DATE";
            $stmtEliminar = $this->conn->prepare($queryEliminar);
            $stmtEliminar->execute();

            return $resultadoMover;
        } catch (PDOException $e) {
            error_log("Error al mover ventas al historial: " . $e->getMessage());
            return false;
        }
    }

    // Método para listar el historial de ventas
    public function listarHistorialVentas($fechaFiltro = '')
    {
        try {
            // Validar formato de fecha (Y-m-d)
            if ($fechaFiltro && !DateTime::createFromFormat('Y-m-d', $fechaFiltro)) {
                throw new Exception("Formato de fecha inválido.");
            }

            // Consulta base
            $query = "SELECT * FROM historial_ventas";
            if (!empty($fechaFiltro)) {
                $query .= " WHERE DATE(fecha_cierre) = :fecha";
            }
            $query .= " ORDER BY fecha_cierre DESC";

            $stmt = $this->conn->prepare($query);
            if (!empty($fechaFiltro)) {
                $stmt->bindParam(':fecha', $fechaFiltro);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al listar historial de ventas: " . $e->getMessage());
            return [];
        } catch (Exception $e) {
            error_log("Error en la validación de fecha: " . $e->getMessage());
            return [];
        }
    }

    // Método para obtener los detalles de una venta específica
    public function obtenerVentaPorId($idVenta)
    {
        try {
            $query = "SELECT * FROM ventas WHERE id_venta = :id_venta";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_venta', $idVenta);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener venta por ID: " . $e->getMessage());
            return null;
        }
    }

    // Método para obtener detalles de una venta específica
    public function obtenerDetallePorId($idVenta)
    {
        $query = "
        SELECT 
            v.fecha_venta, v.total_venta, 
            g.nombre AS producto, dv.cantidad_unidades AS unidades
        FROM ventas v
        INNER JOIN detalle_ventas dv ON dv.id_venta = v.id_venta
        INNER JOIN gaseosas g ON g.id_gaseosa = dv.id_gaseosa
        WHERE v.id_venta = :idVenta
    ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idVenta', $idVenta, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

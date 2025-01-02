<?php
require_once 'Conexion.php';

class DetalleVenta {
    private $conn;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->conn = $conexion->conectar();
    }

    // Método para registrar un detalle de venta
    public function registrarDetalle($idVenta, $idGaseosa, $cantidadUnidades, $cantidadPaquetes) {
        try {
            $query = "INSERT INTO detalle_ventas (id_venta, id_gaseosa, cantidad_unidades, cantidad_paquetes)
                      VALUES (:id_venta, :id_gaseosa, :cantidad_unidades, :cantidad_paquetes)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_venta', $idVenta);
            $stmt->bindParam(':id_gaseosa', $idGaseosa);
            $stmt->bindParam(':cantidad_unidades', $cantidadUnidades);
            $stmt->bindParam(':cantidad_paquetes', $cantidadPaquetes);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al registrar detalle de venta: " . $e->getMessage());
            return false;
        }
    }

    // Método para obtener los detalles de una venta específica
    public function obtenerDetallesPorVenta($idVenta) {
        try {
            $query = "SELECT dv.*, g.nombre AS nombre_gaseosa, g.marca 
                      FROM detalle_venta dv
                      INNER JOIN gaseosas g ON dv.id_gaseosa = g.id_gaseosa
                      WHERE dv.id_venta = :id_venta";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_venta', $idVenta);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener detalles de venta: " . $e->getMessage());
            return [];
        }
    }
}
?>

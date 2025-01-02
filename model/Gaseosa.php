<?php
require_once 'Conexion.php';

class Gaseosa
{
    private $conn;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->conn = $conexion->conectar();
    }

    // 1. Listar todas las gaseosas
    public function listar()
    {
        $sql = "SELECT * FROM gaseosas";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarPaginadas($inicio, $cantidad)
    {
        $sql = "SELECT * FROM gaseosas LIMIT :inicio, :cantidad";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT);
        $stmt->bindValue(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->execute();

        $gaseosas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sqlTotal = "SELECT COUNT(*) AS total FROM gaseosas";
        $stmtTotal = $this->conn->prepare($sqlTotal);
        $stmtTotal->execute();
        $total = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];

        return ['gaseosas' => $gaseosas, 'total' => $total];
    }


    // 2. Agregar una nueva gaseosa
    public function agregar($nombre, $marca, $precio_unidad, $precio_paquete, $stock_unidades, $stock_paquetes, $tamano_paquete)
    {
        $sql = "INSERT INTO gaseosas (nombre, marca, precio_unidad, precio_paquete, stock_unidades, stock_paquetes, tamano_paquete) 
                VALUES (:nombre, :marca, :precio_unidad, :precio_paquete, :stock_unidades, :stock_paquetes, :tamano_paquete)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':marca', $marca);
        $stmt->bindParam(':precio_unidad', $precio_unidad);
        $stmt->bindParam(':precio_paquete', $precio_paquete);
        $stmt->bindParam(':stock_unidades', $stock_unidades);
        $stmt->bindParam(':stock_paquetes', $stock_paquetes);
        $stmt->bindParam(':tamano_paquete', $tamano_paquete); // Cambio aquí
        return $stmt->execute();
    }



    // 3. Actualizar una gaseosa existente
    public function actualizarGaseosa($id, $nombre, $marca, $precioUnidad, $precioPaquete, $stockUnidades, $stockPaquetes)
    {
        try {
            $query = "UPDATE gaseosas 
                      SET nombre = :nombre, marca = :marca, precio_unidad = :precio_unidad, precio_paquete = :precio_paquete, 
                          stock_unidades = :stock_unidades, stock_paquetes = :stock_paquetes
                      WHERE id_gaseosa = :id";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':marca', $marca);
            $stmt->bindParam(':precio_unidad', $precioUnidad);
            $stmt->bindParam(':precio_paquete', $precioPaquete);
            $stmt->bindParam(':stock_unidades', $stockUnidades);
            $stmt->bindParam(':stock_paquetes', $stockPaquetes);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar la gaseosa: " . $e->getMessage());
        }
    }



    // 4. Eliminar una gaseosa
    public function eliminar($id)
    {
        $sql = "DELETE FROM gaseosas WHERE id_gaseosa = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }


    // 5. Buscar una gaseosa por ID
    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM gaseosas WHERE id_gaseosa = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

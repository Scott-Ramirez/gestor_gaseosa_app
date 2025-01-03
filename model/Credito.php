<?php
require_once 'Conexion.php';

class Credito
{
    private $conn;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->conn = $conexion->conectar();
    }

    // Listar todos los créditos
    public function listar()
    {
        $sql = "SELECT * FROM creditos";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Agregar un nuevo crédito
    public function agregar($nombre_cliente, $producto, $monto_total)
    {
        $sql = "INSERT INTO creditos (nombre_cliente, producto, monto_total) 
                VALUES (:nombre_cliente, :producto, :monto_total)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nombre_cliente', $nombre_cliente);
        $stmt->bindParam(':producto', $producto);
        $stmt->bindParam(':monto_total', $monto_total);
        return $stmt->execute();
    }

    // Actualizar un crédito existente
    public function actualizar($id_credito, $nombre_cliente, $producto, $monto_total)
    {
        $sql = "UPDATE creditos 
                SET nombre_cliente = :nombre_cliente, producto = :producto, monto_total = :monto_total
                WHERE id_credito = :id_credito";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_credito', $id_credito);
        $stmt->bindParam(':nombre_cliente', $nombre_cliente);
        $stmt->bindParam(':producto', $producto);
        $stmt->bindParam(':monto_total', $monto_total);
        return $stmt->execute();
    }

    // Eliminar un crédito
    public function eliminar($id_credito)
    {
        $sql = "DELETE FROM creditos WHERE id_credito = :id_credito";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_credito', $id_credito);
        return $stmt->execute();
    }

    // Buscar un crédito por ID
    public function buscarPorId($id_credito)
    {
        $sql = "SELECT * FROM creditos WHERE id_credito = :id_credito";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_credito', $id_credito);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../model/Credito.php';

class CreditoController
{
    private $creditoModel;

    public function __construct()
    {
        $this->creditoModel = new Credito();
    }

    public function listarCreditos()
    {
        return $this->creditoModel->listar();
    }

    public function agregarCredito($nombre_cliente, $producto, $monto_total)
    {
        return $this->creditoModel->agregar($nombre_cliente, $producto, $monto_total);
    }

    public function actualizarCredito($id_credito, $nombre_cliente, $producto, $monto_total)
    {
        return $this->creditoModel->actualizar($id_credito, $nombre_cliente, $producto, $monto_total);
    }

    public function eliminarCredito($id_credito)
    {
        return $this->creditoModel->eliminar($id_credito);
    }

    public function buscarCreditoPorId($id_credito)
    {
        return $this->creditoModel->buscarPorId($id_credito);
    }
}

// Procesar solicitudes desde un formulario (opcional)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $creditoController = new CreditoController();

    // Ejemplo de procesamiento para agregar un crédito
    if (isset($_POST['nombre_cliente'], $_POST['producto'], $_POST['monto_total'])) {
        $nombre_cliente = $_POST['nombre_cliente'];
        $producto = $_POST['producto'];
        $monto_total = $_POST['monto_total'];
        $creditoController->agregarCredito($nombre_cliente, $producto, $monto_total);
        header('Location: ../view/creditoGaseosa.php');
    }
}

<?php
// Incluir el modelo correspondiente
require_once '../model/Venta.php';

class HistorialVentasController
{
    private $ventaModel;

    public function __construct()
    {
        $this->ventaModel = new Venta();
    }

    // Método para mostrar el historial de ventas
    public function mostrarHistorialVentas()
    {
        // Comprobar si existe un filtro de fecha (GET)
        $fechaFiltro = isset($_GET['fecha']) ? $_GET['fecha'] : '';

        // Llamar al modelo para obtener el historial de ventas
        $historial = $this->ventaModel->listarHistorialVentas($fechaFiltro);

        // Incluir la vista de historial de ventas y pasarle los datos
        include '../view/historialVentas.php';
    }
}

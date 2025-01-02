<?php
require_once '../model/Gaseosa.php';

class GaseosaController
{

    private $gaseosaModel;

    public function __construct()
    {
        $this->gaseosaModel = new Gaseosa();
    }

    // Método para listar todas las gaseosas
// Método para listar todas las gaseosas
    public function listarGaseosas()
    {
        return $this->gaseosaModel->listar();
    }

    public function listarGaseosasPaginadas($inicio, $cantidad)
    {
        return $this->gaseosaModel->listarPaginadas($inicio, $cantidad);
    }


    // Método para agregar una nueva gaseosa
    public function agregarGaseosa($nombre, $marca, $precio_unidad, $precio_paquete, $stock_unidades, $stock_paquetes, $tamano_paquete)
    {
        if (empty($nombre) || empty($marca) || $precio_unidad < 0 || $precio_paquete < 0) {
            header('Location: agregarGaseosa.php?mensaje=Error: Datos inválidos');
            exit;
        }
        $resultado = $this->gaseosaModel->agregar($nombre, $marca, $precio_unidad, $precio_paquete, $stock_unidades, $stock_paquetes, $tamano_paquete);
        if ($resultado) {
            header('Location: listarGaseosas.php?mensaje=Gaseosa añadida exitosamente');
        } else {
            header('Location: listarGaseosas.php?mensaje=Error al añadir gaseosa');
        }
    }

    // Método para eliminar gaseosa
    public function eliminarGaseosa($id)
    {
        if (empty($id)) {
            return false;
        }
        return $this->gaseosaModel->eliminar($id);
    }

}

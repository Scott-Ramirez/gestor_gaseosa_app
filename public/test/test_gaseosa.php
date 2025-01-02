<?php
require_once '../../model/Gaseosa.php';

$gaseosaModel = new Gaseosa();

echo "<h2>Pruebas del Modelo Gaseosa</h2>";

// 1. Agregar una nueva gaseosa
echo "<h3>Agregar una nueva gaseosa</h3>";
$agregado = $gaseosaModel->agregar('Coca-Cola', 'Coca-Cola Company', 1.50, 15.00, 100, 10, 10);
if ($agregado) {
    echo "✅ Gaseosa agregada correctamente.<br>";
} else {
    echo "❌ Error al agregar gaseosa.<br>";
}

// 2. Listar todas las gaseosas
echo "<h3>Listar todas las gaseosas</h3>";
$listado = $gaseosaModel->listar();
if (!empty($listado)) {
    echo "<pre>";
    print_r($listado);
    echo "</pre>";
} else {
    echo "No hay gaseosas registradas.<br>";
}

// 3. Buscar una gaseosa por ID
echo "<h3>Buscar una gaseosa por ID</h3>";
$id_buscar = 1; // Cambia este ID según lo necesites
$gaseosa = $gaseosaModel->buscarPorId($id_buscar);
if ($gaseosa) {
    echo "✅ Gaseosa encontrada: <br>";
    echo "<pre>";
    print_r($gaseosa);
    echo "</pre>";
} else {
    echo "❌ No se encontró la gaseosa con ID $id_buscar.<br>";
}

// 4. Actualizar una gaseosa
echo "<h3>Actualizar una gaseosa</h3>";
$id_actualizar = 1; // Cambia este ID según lo necesites
$actualizado = $gaseosaModel->actualizar($id_actualizar, 'Coca-Cola Zero', 'Coca-Cola Company', 1.70, 16.00, 90, 9, 10);
if ($actualizado) {
    echo "✅ Gaseosa actualizada correctamente.<br>";
} else {
    echo "❌ Error al actualizar gaseosa con ID $id_actualizar.<br>";
}

// 5. Eliminar una gaseosa
echo "<h3>Eliminar una gaseosa</h3>";
$id_eliminar = 1; // Cambia este ID según lo necesites
$eliminado = $gaseosaModel->eliminar($id_eliminar);
if ($eliminado) {
    echo "✅ Gaseosa eliminada correctamente.<br>";
} else {
    echo "❌ Error al eliminar gaseosa con ID $id_eliminar.<br>";
}

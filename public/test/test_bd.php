<?php
require_once '../../model/Conexion.php'; // Asegúrate de usar la ruta correcta

$conexion = new Conexion();
$conn = $conexion->conectar();

if ($conn) {
    echo "Conexión exitosa a la base de datos.";
} else {
    echo "Error al conectar a la base de datos. Revisa el archivo de log para más detalles.";
}

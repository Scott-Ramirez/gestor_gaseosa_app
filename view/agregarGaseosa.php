<?php
require_once '../model/Gaseosa.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $marca = $_POST['marca'];
    $precio_unidad = $_POST['precio_unidad'];
    $precio_paquete = $_POST['precio_paquete'];
    $stock_unidades = $_POST['stock_unidades'];
    $stock_paquetes = $_POST['stock_paquetes'];
    $tamano_paquete = $_POST['tamano_paquete'];

    $gaseosaModel = new Gaseosa();
    $success = $gaseosaModel->agregar($nombre, $marca, $precio_unidad, $precio_paquete, $stock_unidades, $stock_paquetes, $tamano_paquete);

    if ($success) {
        $message = "Gaseosa agregada correctamente.";
    } else {
        $message = "Error al agregar la gaseosa.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Ventas de Gaseosas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/main.css">
</head>

<body>
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="logo.png" alt="Logo" width="35" height="35" class="d-inline-block align-text-top me-2">
                Ventas Gaseosas
            </a>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="darkModeSwitch">
                <label class="form-check-label text-light" for="darkModeSwitch">
                    <i class="bi bi-moon-stars"></i>
                </label>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../public/index.php">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../view/registrarVenta.php">
                            <i class="bi bi-cart-plus"></i> Registrar Venta
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../view/verVentas.php">
                            <i class="bi bi-list-check"></i> Ver Ventas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./listarGaseosas.php">
                            <i class="bi bi-cup-straw"></i> Listar Gaseosas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../view/agregarGaseosa.php">
                            <i class="bi bi-plus-circle"></i> Agregar Gaseosa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../view/historialVentas.php">
                            <i class="bi bi-clock-history"></i> Historial de Ventas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../view/creditoGaseosa.php">
                            <i class="bi bi-credit-card"></i> Crédito Gaseosa
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 content">
                <div class="container d-flex justify-content-center align-items-center mt-4">
                    <div class="card shadow-lg p-4"
                        style="width: 100%; max-width: 800px; border-radius: 15px; background: linear-gradient(to right bottom, #ffffff, #f8f9fa);">
                        <h1 class="text-center mb-4 text-prmiary fw-bold">Agregar Nueva Gaseosa</h1>
                        <?php if (!empty($message)): ?>
                            <div class="alert alert-info text-center" style="border-radius: 10px;"><?= $message ?></div>
                        <?php endif; ?>
                        <form method="POST" action="agregarGaseosa.php" class="row g-4">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label fw-bold">
                                    <i class="bi bi-cup"></i> Nombre
                                </label>
                                <input type="text" class="form-control form-control-lg border-2"
                                    style="border-radius: 10px; transition: all 0.3s ease;" id="nombre" name="nombre"
                                    placeholder="Nombre de la gaseosa" required>
                            </div>
                            <div class="col-md-6">
                                <label for="marca" class="form-label fw-bold">
                                    <i class="bi bi-building"></i> Marca
                                </label>
                                <input type="text" class="form-control form-control-lg border-2"
                                    style="border-radius: 10px; transition: all 0.3s ease;" id="marca" name="marca"
                                    placeholder="Marca de la gaseosa" required>
                            </div>
                            <div class="col-md-6">
                                <label for="precio_unidad" class="form-label fw-bold">
                                    <i class="bi bi-currency-dollar"></i> Precio Unidad
                                </label>
                                <input type="number" step="0.01" class="form-control form-control-lg border-2"
                                    style="border-radius: 10px; transition: all 0.3s ease;" id="precio_unidad"
                                    name="precio_unidad" placeholder="Precio por unidad" required>
                            </div>
                            <div class="col-md-6">
                                <label for="precio_paquete" class="form-label fw-bold">
                                    <i class="bi bi-box"></i> Precio Paquete
                                </label>
                                <input type="number" step="0.01" class="form-control form-control-lg border-2"
                                    style="border-radius: 10px; transition: all 0.3s ease;" id="precio_paquete"
                                    name="precio_paquete" placeholder="Precio por paquete (opcional)">
                            </div>
                            <div class="col-md-6">
                                <label for="stock_unidades" class="form-label fw-bold">
                                    <i class="bi bi-archive"></i> Stock Unidades
                                </label>
                                <input type="number" class="form-control form-control-lg border-2"
                                    style="border-radius: 10px; transition: all 0.3s ease;" id="stock_unidades"
                                    name="stock_unidades" placeholder="Cantidad en unidades" required>
                            </div>
                            <div class="col-md-6">
                                <label for="stock_paquetes" class="form-label fw-bold">
                                    <i class="bi bi-boxes"></i> Stock Paquetes
                                </label>
                                <input type="number" class="form-control form-control-lg border-2"
                                    style="border-radius: 10px; transition: all 0.3s ease;" id="stock_paquetes"
                                    name="stock_paquetes" placeholder="Cantidad en paquetes (opcional)">
                            </div>
                            <div class="col-md-12">
                                <label for="tamano_paquete" class="form-label fw-bold">
                                    <i class="bi bi-box-seam"></i> Tamaño Paquete
                                </label>
                                <input type="number" class="form-control form-control-lg border-2"
                                    style="border-radius: 10px; transition: all 0.3s ease;" id="tamano_paquete"
                                    name="tamano_paquete" placeholder="Unidades por paquete (opcional)">
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <button type="submit" class="btn btn-primary btn-lg px-4 py-2"
                                    style="border-radius: 10px; transition: all 0.3s ease;">
                                    <i class="bi bi-save"></i> Guardar
                                </button>
                                <a href="listarGaseosas.php" class="btn btn-secondary btn-lg px-4 py-2"
                                    style="border-radius: 10px; transition: all 0.3s ease;">
                                    <i class="bi bi-arrow-left"></i> Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script src="../public/js/dark_mode.js"></script>
        </div>
</body>

</html>
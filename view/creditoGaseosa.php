<?php
require_once '../controller/creditoController.php';
require_once '../controller/GaseosaController.php'; // Incluir el controlador de Gaseosa
$creditoController = new CreditoController();
$gaseosaController = new GaseosaController(); // Instanciar el controlador de Gaseosa
$creditos = $creditoController->listarCreditos();
$productos = $gaseosaController->listarGaseosas(); // Obtener la lista de productos
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crédito Gaseosa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> <!-- Agregado para los iconos -->
    <link rel="stylesheet" href="../public/css/main.css">
</head>

<body>
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Ventas Gaseosas</a>
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
                    <li class="nav-item"><a class="nav-link active" href="../public/index.php"><i
                                class="bi bi-speedometer2"></i> Dashboard</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="../view/registrarVenta.php"><i
                                class="bi bi-plus-circle"></i> Registrar Venta</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="../view/verVentas.php"><i class="bi bi-list-ul">
                            </i>
                            Ver Ventas</a></li>
                    <li class="nav-item"><a class="nav-link" href="../view/listarGaseosas.php"><i
                                class="bi bi-boxes"></i> Listar Gaseosas</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="./agregarGaseosa.php"><i
                                class="bi bi-plus-circle-fill"></i> Agregar Gaseosa</a>
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
                <div class="container mt-2">
                    <h1>Crédito Gaseosa</h1>
                    <div class="row">
                        <div class="col-md-4"> <!-- Cambiado de col-md-6 a col-md-4 para reducir el ancho -->
                            <form method="POST" action="../controller/creditoController.php">
                                <div class="mb-3">
                                    <label for="nombre_cliente" class="form-label">Nombre del Cliente:</label>
                                    <input type="text" id="nombre_cliente" name="nombre_cliente" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="producto" class="form-label">Producto:</label>
                                    <select id="producto" name="producto" class="form-select" required>
                                        <option value="">Seleccione un producto</option>
                                        <?php foreach ($productos as $producto): ?>
                                            <option value="<?= htmlspecialchars($producto['nombre']); ?>"><?= htmlspecialchars($producto['nombre']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="monto_total" class="form-label">Monto Total:</label>
                                    <input type="number" id="monto_total" name="monto_total" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Guardar Crédito</button>
                            </form>
                        </div>
                        <div class="col-md-8"> <!-- Cambiado de col-md-6 a col-md-8 para ajustar el espacio -->
                            
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nombre del Cliente</th>
                                        <th>Producto</th>
                                        <th>Monto Total</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($creditos as $credito): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($credito['nombre_cliente']); ?></td>
                                            <td><?= htmlspecialchars($credito['producto']); ?></td>
                                            <td><?= htmlspecialchars($credito['monto_total']); ?></td>
                                            <td>
                                                <a href="../controller/creditoController.php?action=editar&id=<?= $credito['id_credito']; ?>" class="btn btn-warning btn-sm">Actualizar</a>
                                                <a href="../controller/creditoController.php?action=eliminar&id=<?= $credito['id_credito']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/dark_mode.js"></script>
</body>

</html>

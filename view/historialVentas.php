<?php
// Incluir el encabezado común o iniciar sesión si es necesario

// Si el controlador pasa los datos correctamente, no necesitas instanciar el modelo aquí.
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
                <div class="container mt-5">
                    <h1>Historial de Ventas</h1>

                    <!-- Formulario de búsqueda por fecha -->
                    <form method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="date" class="form-control" name="fecha"
                                value="<?php echo htmlspecialchars($fechaFiltro); ?>" required>
                            <button class="btn btn-primary" type="submit">Buscar</button>
                        </div>
                    </form>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Fecha de Venta</th>
                                <th>Total de Venta (S/)</th>
                                <th>Fecha de Cierre</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($historial)): ?>
                                <?php foreach ($historial as $venta): ?>
                                    <tr>
                                        <td><?php echo (new DateTime($venta['fecha_venta']))->format('d/m/Y H:i:s'); ?></td>
                                        <td>S/. <?php echo htmlspecialchars($venta['total_venta']); ?></td>
                                        <td><?php echo (new DateTime($venta['fecha_cierre']))->format('d/m/Y H:i:s'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center">No hay ventas en el historial.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/dark_mode.js"></script>
</body>

</html>

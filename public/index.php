<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Ventas de Gaseosas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/main.css">
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
                        <a class="nav-link active" aria-current="page" href="./index.php">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../view/registrarVenta.php">
                            <i class="bi bi-plus-circle"></i> Registrar Venta
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../view/verVentas.php">
                            <i class="bi bi-list-ul"></i> Ver Ventas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../view/listarGaseosas.php">
                            <i class="bi bi-boxes"></i> Listar Gaseosas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../view/agregarGaseosa.php">
                            <i class="bi bi-plus-circle-fill"></i> Agregar Gaseosa
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="../view/eliminarGaseosa.php">
                            <i class="bi bi-trash"></i> Eliminar Gaseosa
                        </a>
                    </li> -->
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
                <h1>Dashboard</h1>
                <p class="lead text-muted">Bienvenido al sistema de administración de ventas.</p>

                <!-- Botones CRUD -->
                <div class="d-flex justify-content-end mb-4">
                    <a href="../view/agregarGaseosa.php" class="btn btn-success me-2">
                        <i class="bi bi-plus-circle-fill"></i> Agregar Gaseosa
                    </a>
                    <a href="../view/listarGaseosas.php" class="btn btn-primary me-2">
                        <i class="bi bi-boxes"></i> Listar Gaseosas
                    </a>
                    <a href="../view/eliminarGaseosa.php" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Eliminar Gaseosa
                    </a>
                </div>

                <!-- Dashboard Stats -->
                <div class="row dashboard-stats">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <h3 class="text-primary"><i class="bi bi-cart-check"></i> Ventas Hoy</h3>
                            <h2 id="ventasHoy">0</h2>
                            <p class="text-muted" id="comparacionVentas"></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <h3 class="text-warning"><i class="bi bi-currency-dollar"></i> Ingresos Totales</h3>
                            <h2 id="ingresosTotales">S/. 0.00</h2>
                            <p class="text-muted" id="comparacionIngresos"></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <h3 class="text-success"><i class="bi bi-box-seam"></i> Total Gaseosas</h3>
                            <h2 id="totalGaseosas">0</h2>
                            <p class="text-muted">Tipos diferentes de gaseosas</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <h3 class="text-info"><i class="bi bi-exclamation-triangle"></i> Stock Bajo</h3>
                            <h2 id="stockBajo">0</h2>
                            <p class="text-warning">Productos con bajo stock</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="./js/dark_mode.js"></script>
    <script src="./js/main.js"></script>
</body>

</html>

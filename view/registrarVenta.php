<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Venta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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

    <?php
    date_default_timezone_set('America/Lima'); // Cambia 'America/Lima' a tu zona horaria
    ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_GET['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

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

            <div class="col-md-9 col-lg-10 content">
                <div class="container" style="max-width: 800px;">
                    <h1>Registrar Nueva Venta</h1>

                    <form id="formVenta" class="mt-4" method="POST" action="../controller/VentaController.php">
                        <input type="hidden" name="action" value="registrarVenta">

                        <div class="mb-4">
                            <label for="fechaVenta" class="form-label">Fecha y Hora de la Venta:</label>
                            <input type="datetime-local" id="fechaVenta" name="fecha_venta" class="form-control"
                                value="<?php echo date('Y-m-d\TH:i'); ?>" required>
                        </div>


                        <div class="mb-4">
                            <h5>Productos a Vender</h5>
                            <div id="productosContainer">
                                <div class="row producto-row mb-3">
                                    <div class="col-md-3">
                                        <label for="gaseosa-select" class="form-label">Seleccione la Gaseosa:</label>
                                        <select class="form-select gaseosa-select" name="id_gaseosa[]" required>
                                            <option value="">-- Seleccione una Gaseosa --</option>
                                            <?php
                                            require_once '../controller/GaseosaController.php';
                                            $gaseosaController = new GaseosaController();
                                            $gaseosas = $gaseosaController->listarGaseosas();
                                            foreach ($gaseosas as $gaseosa) {
                                                echo "<option value='" . $gaseosa['id_gaseosa'] . "' 
                                                data-precio-unidad='" . $gaseosa['precio_unidad'] . "'
                                                data-precio-paquete='" . $gaseosa['precio_paquete'] . "'>"
                                                    . $gaseosa['nombre'] . " - " . $gaseosa['marca'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="cantidad-unidades" class="form-label">Cantidad Unidades:</label>
                                        <input type="number" class="form-control cantidad-unidades"
                                            name="cantidad_unidades[]" placeholder="Ingrese unidades" min="0" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="cantidad-paquetes" class="form-label">Cantidad Paquetes:</label>
                                        <input type="number" class="form-control cantidad-paquetes"
                                            name="cantidad_paquetes[]" placeholder="Ingrese paquetes" min="0" value="0">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="precio-unitario" class="form-label">Precio por Unidad:</label>
                                        <input type="text" class="form-control precio-unitario" name="precio_unitario[]"
                                            placeholder="S/. 0.00" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="precio-paquete" class="form-label">Precio por Paquete:</label>
                                        <input type="text" class="form-control precio-paquete" name="precio_paquete[]"
                                            placeholder="S/. 0.00" readonly>
                                    </div>
                                    <div class="col-md-1">
                                        <label class="form-label">Eliminar:</label>
                                        <button type="button" class="btn btn-danger btn-remove-producto"
                                            title="Eliminar producto">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary" id="btnAgregarProducto">
                                <i class="bi bi-plus-circle"></i> Agregar Otro Producto
                            </button>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <h5>Total de la Venta:</h5>
                                <h5 id="totalVenta">S/. 0.00</h5>
                                <input type="hidden" name="total_venta" id="total_venta_input">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-save"></i> Guardar Venta
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../public/js/dark_mode.js"></script>
    <script src="../public/js/main.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Verificar si hay un parámetro de status en la URL
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');

            if (status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'La venta se ha registrado correctamente',
                    showConfirmButton: true
                }).then((result) => {
                    // Limpiar la URL después de mostrar el mensaje
                    window.history.replaceState({}, document.title, window.location.pathname);

                    // Limpiar el formulario
                    document.getElementById('formVenta').reset();

                    // Actualizar los campos de precio y total
                    document.querySelectorAll('.precio-unitario, .precio-paquete').forEach(input => {
                        input.value = '';
                    });
                    document.getElementById('totalVenta').textContent = 'S/. 0.00';
                    document.getElementById('total_venta_input').value = '0.00';
                });
            }
        });
    </script>
    <!-- Actualiizar Hora automaticamente -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function actualizarHora() {
                const fechaVentaInput = document.getElementById('fechaVenta');
                if (fechaVentaInput) {
                    const ahora = new Date();
                    const año = ahora.getFullYear();
                    const mes = String(ahora.getMonth() + 1).padStart(2, '0'); // Meses van de 0-11
                    const día = String(ahora.getDate()).padStart(2, '0');
                    const horas = String(ahora.getHours()).padStart(2, '0');
                    const minutos = String(ahora.getMinutes()).padStart(2, '0');

                    // Formato: YYYY-MM-DDTHH:mm
                    const fechaLocal = `${año}-${mes}-${día}T${horas}:${minutos}`;
                    fechaVentaInput.value = fechaLocal;
                }
            }

            // Actualizar cada segundo
            setInterval(actualizarHora, 1000);

            // Inicializar con la hora actual
            actualizarHora();
        });

    </script>
</body>

</html>
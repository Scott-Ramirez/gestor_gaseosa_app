<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas por Día - Ventas Gaseosas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/main.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    date_default_timezone_set('America/Lima'); // Configurar la zona horaria
    ?>
</head>

<body>
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../public/assets/logo.png" alt="Logo" width="35" height="35"
                    class="d-inline-block align-text-top me-2">
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
                <h2 class="my-4">Ventas por Día</h2>

                <?php
                $fechaHoy = date('Y-m-d');
                ?>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="m-0">Ventas del Día: <?php echo $fechaHoy; ?></h4>
                    <a href="../controller/cerrarCaja.php" class="btn btn-danger cerrar-caja">
                        <i class="bi bi-x-circle"></i> Cerrar Caja
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover ventas-tabla">
                        <thead class="table-dark">
                            <tr>
                                <th>Fecha de Venta</th>
                                <th>Total de Venta (S/)</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once '../model/Venta.php';
                            $ventaModel = new Venta();
                            $ventas = $ventaModel->listarVentasDelDia();

                            if (!empty($ventas)) {
                                foreach ($ventas as $venta) {
                                    echo "<tr>";
                                    echo "<td>{$venta['fecha_venta']}</td>";
                                    echo "<td>{$venta['total_venta']}</td>";
                                    echo "<td>";
                                    echo "<button class='btn btn-info btn-sm me-2 ver-detalle' data-id='{$venta['id_venta']}'><i class='bi bi-eye'></i> Ver Detalles</button>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3' class='text-center'>No hay ventas registradas para hoy.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Detalle de Venta -->
    <div class="modal fade" id="detalleVentaModal" tabindex="-1" aria-labelledby="detalleVentaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detalleVentaModalLabel">Detalle de Venta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Fecha:</strong> <span id="detalleFecha"></span></p>
                    <p><strong>Hora:</strong> <span id="detalleHora"></span></p>
                    <p><strong>Monto Total:</strong> S/ <span id="detalleMonto"></span></p>
                    <h6>Productos Vendidos:</h6>
                    <ul id="detalleProductos"></ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/dark_mode.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Vaciar tabla al cerrar caja
            document.querySelector('.cerrar-caja').addEventListener('click', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¿Deseas cerrar la caja del día?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, cerrar caja',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Vaciar la tabla
                        document.querySelector('.ventas-tabla tbody').innerHTML =
                            '<tr><td colspan="3" class="text-center">No hay ventas registradas para hoy.</td></tr>';
                        window.location.href = this.href; // Redirigir para procesar cierre
                    }
                });
            });

            // Ver detalles de la venta en el modal
            document.querySelectorAll('.ver-detalle').forEach((boton) => {
                boton.addEventListener('click', function () {
                    const idVenta = this.dataset.id;

                    fetch(`../controller/detalleVenta.php?id=${idVenta}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Error en la respuesta del servidor');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Asegúrate de que estás accediendo a los datos correctamente
                            if (data.error) {
                                alert(data.error); // Si hay un error en la respuesta, muéstralo
                            } else {
                                // Procesa los datos aquí
                                // Mostrar detalles en la interfaz
                                mostrarDetalles(data);
                                // Mostrar el modal
                                const modal = new bootstrap.Modal(document.getElementById('detalleVentaModal'));
                                modal.show();
                            }
                        })
                        .catch(error => {
                            console.error('Error al obtener los detalles de la venta:', error);
                        });
                });
            });

            function mostrarDetalles(data) {
                // Actualizar el modal con los detalles de la venta
                const fechaCompleta = new Date(data.fecha);
                document.getElementById('detalleFecha').textContent = fechaCompleta.toLocaleDateString('es-PE'); // Solo la fecha
                document.getElementById('detalleHora').textContent = fechaCompleta.toLocaleTimeString('es-PE', { hour: '2-digit', minute: '2-digit' }); // Solo la hora
                document.getElementById('detalleMonto').textContent = data.monto; // Asegúrate de que esto sea correcto

                const listaProductos = document.getElementById('detalleProductos');
                listaProductos.innerHTML = ''; // Limpiar lista de productos antes de agregar nuevos

                data.productos.forEach(producto => {
                    const li = document.createElement('li');
                    li.textContent = `${producto.producto} - S/ ${producto.total_venta} x ${producto.unidades}`;
                    listaProductos.appendChild(li);
                });
            }
        });
    </script>
</body>

</html>

<?php
require_once '../controller/GaseosaController.php';

// Variables para la paginación
$registrosPorPagina = 6;
$paginaActual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
if ($paginaActual < 1)
    $paginaActual = 1;

$inicio = ($paginaActual - 1) * $registrosPorPagina;

// Instanciar el controlador y obtener los datos paginados
$gaseosaController = new GaseosaController();
$datosPaginados = $gaseosaController->listarGaseosasPaginadas($inicio, $registrosPorPagina);
$gaseosas = $datosPaginados['gaseosas'];
$totalRegistros = $datosPaginados['total'];
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Ventas de Gaseosas</title>
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
                    <h1>Listado de Gaseosas</h1>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Marca</th>
                                <th>Precio Unidad</th>
                                <th>Precio Paquete</th>
                                <th>Stock Unidades</th>
                                <th>Stock Paquetes</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($gaseosas)): ?>
                                <?php foreach ($gaseosas as $gaseosa): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($gaseosa['nombre']); ?></td>
                                        <td><?php echo htmlspecialchars($gaseosa['marca']); ?></td>
                                        <td>S/. <?php echo htmlspecialchars($gaseosa['precio_unidad']); ?></td>
                                        <td>S/. <?php echo htmlspecialchars($gaseosa['precio_paquete']); ?></td>
                                        <td><?php echo htmlspecialchars($gaseosa['stock_unidades']); ?></td>
                                        <td><?php echo htmlspecialchars($gaseosa['stock_paquetes']); ?></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#updateModal"
                                                onclick="loadUpdateData(<?php echo htmlspecialchars(json_encode($gaseosa)); ?>)">
                                                <i class="bi bi-pencil"></i> Editar
                                            </button>
                                            <button class="btn btn-danger btn-sm"
                                                onclick="confirmDelete(<?php echo htmlspecialchars($gaseosa['id_gaseosa']); ?>)">
                                                <i class="bi bi-trash"></i> Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No hay gaseosas registradas.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <!-- Paginación -->
                    <nav>
                        <ul class="pagination">
                            <li class="page-item <?php echo $paginaActual <= 1 ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?pagina=<?php echo $paginaActual - 1; ?>">Anterior</a>
                            </li>
                            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                                <li class="page-item <?php echo $i == $paginaActual ? 'active' : ''; ?>">
                                    <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?php echo $paginaActual >= $totalPaginas ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?pagina=<?php echo $paginaActual + 1; ?>">Siguiente</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para actualizar -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="../controller/updateGaseosa.php" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Actualizar Gaseosa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="update-id" name="id">
                        <div class="mb-3">
                            <label for="update-nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="update-nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="update-marca" class="form-label">Marca</label>
                            <input type="text" class="form-control" id="update-marca" name="marca" required>
                        </div>
                        <div class="mb-3">
                            <label for="update-precio-unidad" class="form-label">Precio Unidad</label>
                            <input type="number" class="form-control" id="update-precio-unidad" name="precio_unidad"
                                step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="update-precio-paquete" class="form-label">Precio Paquete</label>
                            <input type="number" class="form-control" id="update-precio-paquete" name="precio_paquete"
                                step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="update-stock-unidades" class="form-label">Stock Unidades</label>
                            <input type="number" class="form-control" id="update-stock-unidades" name="stock_unidades"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="update-stock-paquetes" class="form-label">Stock Paquetes</label>
                            <input type="number" class="form-control" id="update-stock-paquetes" name="stock_paquetes"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../public/js/dark_mode.js"></script>
    <script>
        // Cargar datos al modal de actualización
        function loadUpdateData(gaseosa) {
            document.getElementById('update-id').value = gaseosa.id_gaseosa;
            document.getElementById('update-nombre').value = gaseosa.nombre;
            document.getElementById('update-marca').value = gaseosa.marca;
            document.getElementById('update-precio-unidad').value = gaseosa.precio_unidad;
            document.getElementById('update-precio-paquete').value = gaseosa.precio_paquete;
            document.getElementById('update-stock-unidades').value = gaseosa.stock_unidades;
            document.getElementById('update-stock-paquetes').value = gaseosa.stock_paquetes;
        }

        // Confirmar eliminación con SweetAlert
        function confirmDelete(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../controller/eliminarGaseosa.php?id=' + id;
                }
            });
        }

        // Verificar mensajes al cargar la página
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');

            if (status === 'success') {
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'La gaseosa se eliminó correctamente',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    // Limpiar la URL después de mostrar el mensaje
                    window.history.replaceState({}, document.title, window.location.pathname);
                });
            } else if (status === 'error') {
                Swal.fire({
                    title: 'Error',
                    text: 'Ocurrió un error al eliminar la gaseosa',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    // Limpiar la URL después de mostrar el mensaje
                    window.history.replaceState({}, document.title, window.location.pathname);
                });
            }
        });
    </script>
</body>

</html>
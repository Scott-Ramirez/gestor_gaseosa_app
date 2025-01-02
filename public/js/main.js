// Logica de ventas 
document.addEventListener("DOMContentLoaded", function () {
    const productosContainer = document.getElementById("productosContainer");
    const btnAgregarProducto = document.getElementById("btnAgregarProducto");
    const totalVentaElement = document.getElementById("totalVenta");
    const totalVentaInput = document.getElementById("total_venta_input");

    // Función para calcular el total de la venta
    function calcularTotalVenta() {
        let total = 0;
        document.querySelectorAll(".producto-row").forEach((row) => {
            const precioUnitario = parseFloat(row.querySelector(".precio-unitario").value) || 0;
            const precioPaquete = parseFloat(row.querySelector(".precio-paquete").value) || 0;
            const cantidadUnidades = parseInt(row.querySelector(".cantidad-unidades").value) || 0;
            const cantidadPaquetes = parseInt(row.querySelector(".cantidad-paquetes").value) || 0;

            total += (precioUnitario * cantidadUnidades) + (precioPaquete * cantidadPaquetes);
        });

        totalVentaElement.textContent = `S/. ${total.toFixed(2)}`;
        totalVentaInput.value = total.toFixed(2);
    }

    // Agregar una nueva fila de producto
    btnAgregarProducto.addEventListener("click", function () {
        const nuevoProducto = document.querySelector(".producto-row").cloneNode(true);

        // Limpiar valores de los campos en la nueva fila
        nuevoProducto.querySelector(".gaseosa-select").value = "";
        nuevoProducto.querySelector(".cantidad-unidades").value = "";
        nuevoProducto.querySelector(".cantidad-paquetes").value = "0";
        nuevoProducto.querySelector(".precio-unitario").value = "";
        nuevoProducto.querySelector(".precio-paquete").value = "";

        // Agregar event listeners a los nuevos inputs
        agregarEventosFila(nuevoProducto);

        productosContainer.appendChild(nuevoProducto);
    });

    // Función para agregar eventos a una fila de producto
    function agregarEventosFila(row) {
        const selectGaseosa = row.querySelector(".gaseosa-select");
        const cantidadUnidades = row.querySelector(".cantidad-unidades");
        const cantidadPaquetes = row.querySelector(".cantidad-paquetes");
        const precioUnitario = row.querySelector(".precio-unitario");
        const precioPaquete = row.querySelector(".precio-paquete");
        const btnEliminar = row.querySelector(".btn-remove-producto");

        // Actualizar precios cuando se selecciona una gaseosa
        selectGaseosa.addEventListener("change", function () {
            const optionSelected = selectGaseosa.options[selectGaseosa.selectedIndex];
            precioUnitario.value = optionSelected.getAttribute("data-precio-unidad") || 0;
            precioPaquete.value = optionSelected.getAttribute("data-precio-paquete") || 0;
            calcularTotalVenta();
        });

        // Recalcular total cuando cambian las cantidades
        [cantidadUnidades, cantidadPaquetes].forEach(input => {
            input.addEventListener("input", calcularTotalVenta);
        });

        // Eliminar fila
        btnEliminar.addEventListener("click", function () {
            row.remove();
            calcularTotalVenta();
        });
    }

    // Inicializar eventos en las filas existentes
    document.querySelectorAll(".producto-row").forEach(agregarEventosFila);
});

document.getElementById('formVenta').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validar que haya al menos un producto
    const filas = document.querySelectorAll('.producto-row');
    let isValid = true;
    
    filas.forEach(fila => {
        const gaseosa = fila.querySelector('.gaseosa-select').value;
        const unidades = parseInt(fila.querySelector('.cantidad-unidades').value) || 0;
        const paquetes = parseInt(fila.querySelector('.cantidad-paquetes').value) || 0;
        
        if (!gaseosa || (unidades === 0 && paquetes === 0)) {
            isValid = false;
        }
    });

    if (!isValid) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor, seleccione al menos un producto y especifique la cantidad'
        });
        return;
    }

    // Si todo está bien, enviar el formulario
    this.submit();
});

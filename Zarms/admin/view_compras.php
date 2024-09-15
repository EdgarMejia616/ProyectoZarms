<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Compras</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Estilos del botón de regresar */
.return-button {
    position: absolute;
    top: 20px;
    left: 20px;
    display: flex;
    align-items: center;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 10px;
    cursor: pointer;
    font-size: 16px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    z-index: 10;
    text-decoration: none;
}

.return-button i {
    margin-right: 8px;
}

.return-button:hover {
    background-color: #0056b3;
}

        /* Estilo para la notificación emergente */
        .notification {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            z-index: 1000;
        }
        .notification.success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }
        .notification .close-btn {
            float: right;
            margin-left: 10px;
            cursor: pointer;
            font-weight: bold;
        }

        /* Estilos para la tabla y el formulario */
        .container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }
        .register-container, .table-container {
            flex: 1;
        }
        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }
        .table-container th, .table-container td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table-container th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <!-- Contenedor de la notificación -->
    <div id="notification" class="notification">
        <span id="notification-message"></span>
        <span class="close-btn" onclick="closeNotification()">x</span>
    </div>
    <a href="dashboard.php" class="return-button">
    <i class="fa fa-arrow-left"></i> Regresar
</a>
    <div class="container">
        <!-- Formulario de compra -->
        <div class="register-container">
            <h1>Registrar Compra</h1>

            <form id="compra-form">
                <!-- Selección del proveedor -->
                <div class="input-box">
                    <label for="id_proveedor">Proveedor:</label>
                    <select id="id_proveedor" name="id_proveedor" required>
                        <option value="">Selecciona un proveedor</option>
                        <?php
                        include 'db_connection.php';
                        $result = $conn->query("SELECT id_proveedor, nombre FROM proveedor");
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id_proveedor'] . "'>" . $row['nombre'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Selección de producto según proveedor -->
                <div class="input-box">
                    <label for="id_producto">Producto:</label>
                    <select id="id_producto" name="id_producto" required>
                        <option value="">Selecciona un producto</option>
                    </select>
                </div>

                <!-- Mostrar nombre del producto -->
                <div class="input-box">
                    <label for="nombre_producto">Nombre del Producto:</label>
                    <input type="text" id="nombre_producto" name="nombre_producto" readonly>
                </div>

                <!-- Cantidad -->
                <div class="input-box">
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" id="cantidad" name="cantidad" required>
                </div>

                <!-- Precio del producto -->
                <div class="input-box">
                    <label for="precio">Precio:</label>
                    <input type="number" id="precio" name="precio" readonly>
                </div>

                <!-- Total -->
                <div class="input-box">
                    <label for="total">Total:</label>
                    <input type="text" id="total" name="total" readonly>
                </div>

                <!-- Fecha -->
                <div class="input-box">
                    <label for="fecha">Fecha:</label>
                    <input type="date" id="fecha" name="fecha" required>
                </div>

                <div class="button-container">
                    <button type="submit">Registrar Compra</button>
                </div>
            </form>
        </div>

        <!-- Tabla de compras -->
        <div class="table-container">
            <h1>Datos de Compras</h1>
            <div class="input-box">
                <label for="search_proveedor">Buscar por Proveedor:</label>
                <select id="search_proveedor">
                    <option value="">Selecciona un proveedor</option>
                    <?php
                    $result = $conn->query("SELECT id_proveedor, nombre FROM proveedor");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id_proveedor'] . "'>" . $row['nombre'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <table id="compras-table">
                <thead>
                    <tr>
                        <th>ID Compra</th>
                        <th>Proveedor</th>
                        <th>Producto</th>
                        <th>Nombre Producto</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí se llenará la tabla con datos mediante JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
    <script>
        // Función para obtener y mostrar los productos según el proveedor seleccionado
        document.getElementById('id_proveedor').addEventListener('change', function() {
            var id_proveedor = this.value;

            // Limpiar el select de productos
            document.getElementById('id_producto').innerHTML = '<option value="">Selecciona un producto</option>';
            document.getElementById('nombre_producto').value = '';
            document.getElementById('precio').value = '';
            document.getElementById('cantidad').value = '';
            document.getElementById('total').value = '';

            if (id_proveedor) {
                // Llamada AJAX para obtener productos del proveedor seleccionado
                fetch('get_productos.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'id_proveedor=' + id_proveedor
                })
                .then(response => response.json())
                .then(data => {
                    data.forEach(function(producto) {
                        var option = document.createElement('option');
                        option.value = producto.id_producto;
                        option.textContent = producto.nombre_producto;
                        option.dataset.precio = producto.precio;
                        document.getElementById('id_producto').appendChild(option);
                    });
                });
            }
        });

        document.getElementById('id_producto').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            document.getElementById('nombre_producto').value = selectedOption.textContent;
            document.getElementById('precio').value = selectedOption.dataset.precio;
            calcularTotal();
        });

        document.getElementById('cantidad').addEventListener('input', function() {
            calcularTotal();
        });

        function calcularTotal() {
            var cantidad = document.getElementById('cantidad').value;
            var precio = document.getElementById('precio').value;
            if (cantidad && precio) {
                var total = cantidad * precio;
                document.getElementById('total').value = total.toFixed(2);
            } else {
                document.getElementById('total').value = '';
            }
        }

        document.getElementById('compra-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar el envío normal del formulario

            var formData = new FormData(this);
            fetch('save_compra.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                showNotification(data.message, data.status);
                if (data.status === 'success') {
                    // Limpiar el formulario
                    document.getElementById('compra-form').reset();
                    // Recargar la tabla de compras
                    loadCompras();
                }
            });
        });

        function showNotification(message, status) {
            var notification = document.getElementById('notification');
            var notificationMessage = document.getElementById('notification-message');
            notificationMessage.textContent = message;
            notification.className = 'notification ' + (status === 'success' ? 'success' : 'error');
            notification.style.display = 'block';
        }

        function closeNotification() {
            document.getElementById('notification').style.display = 'none';
        }

        // Función para cargar los datos de compras en la tabla
        function loadCompras(id_proveedor = '') {
            fetch('get_compras.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id_proveedor=' + id_proveedor
            })
            .then(response => response.json())
            .then(data => {
                var tableBody = document.getElementById('compras-table').getElementsByTagName('tbody')[0];
                tableBody.innerHTML = ''; // Limpiar la tabla

                data.forEach(function(compra) {
                    var row = tableBody.insertRow();
                    row.insertCell(0).textContent = compra.id_compra;
                    row.insertCell(1).textContent = compra.nombre_proveedor;
                    row.insertCell(2).textContent = compra.nombre_producto;
                    row.insertCell(3).textContent = compra.nombre_producto;
                    row.insertCell(4).textContent = compra.cantidad;
                    row.insertCell(5).textContent = compra.fecha;
                    row.insertCell(6).textContent = compra.total;
                });
            });
        }

        // Cargar los datos de compras al cargar la página
        loadCompras();

        // Función para buscar compras por proveedor
        document.getElementById('search_proveedor').addEventListener('change', function() {
            var id_proveedor = this.value;
            loadCompras(id_proveedor);
        });
    </script>
</body>
</html>

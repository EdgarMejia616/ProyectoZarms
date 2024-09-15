<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Producto</title>
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

    </style>
</head>
<body>
<a href="dashboard.php" class="return-button">
    <i class="fa fa-arrow-left"></i> Regresar
</a>

    <div class="register-container">
        <h1>Registrar Producto</h1>

        <!-- Notificación -->
        <div id="notification" class="notification" style="display: none;">
            <span id="notification-message"></span>
            <span id="notification-close" class="notification-close">&times;</span>
        </div>

        <form id="product-form" method="POST" action="save_product.php" enctype="multipart/form-data">
            <!-- Campos del formulario -->
            <div class="input-box">
                <label for="nombre_producto">Nombre del Producto:</label>
                <input type="text" id="nombre_producto" name="nombre_producto" required>
            </div>

            <div class="input-box">
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" step="0.01" required>
            </div>

            <div class="input-box">
                <label for="categoria_id">Categoría:</label>
                <select id="categoria_id" name="categoria_id" onchange="updateCategoria(this)" required>
                    <option value="">Selecciona una categoría</option>
                    <?php
                    include 'db_connection.php';
                    $result = $conn->query("SELECT categoria_id, categoria FROM categoria");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['categoria_id'] . "' data-nombre='" . $row['categoria'] . "'>" . $row['categoria'] . "</option>";
                    }
                    ?>
                </select>
                <input type="hidden" id="categoria" name="categoria">
            </div>

            <div class="input-box">
                <label for="marca_id">Marca:</label>
                <select id="marca_id" name="marca_id" onchange="updateMarca(this)" required>
                    <option value="">Selecciona una marca</option>
                    <?php
                    $result = $conn->query("SELECT marca_id, marca FROM marca");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['marca_id'] . "' data-nombre='" . $row['marca'] . "'>" . $row['marca'] . "</option>";
                    }
                    ?>
                </select>
                <input type="hidden" id="marca" name="marca">
            </div>

            <div class="input-box">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion"></textarea>
            </div>

            <div class="input-box">
                <label for="cantidad">Cantidad:</label>
                <input type="number" id="cantidad" name="cantidad" required>
            </div>

            <div class="input-box">
                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen">
            </div>

            <div class="input-box">
                <label for="estado">Estado:</label>
                <select id="estado" name="estado" required>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
            </div>

            <div class="input-box">
                <label for="id_proveedor">Proveedor:</label>
                <select id="id_proveedor" name="id_proveedor" required>
                    <option value="">Selecciona un proveedor</option>
                    <?php
                    $result = $conn->query("SELECT id_proveedor, nombre FROM proveedor");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id_proveedor'] . "'>" . $row['nombre'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="button-container">
                <button type="submit">Registrar Producto</button>
                <a href="view_products.php" class="view-table-button">Ver Tabla</a>
            </div>
        </form>
    </div>

    <script>
        function updateCategoria(select) {
            var categoriaNombre = select.options[select.selectedIndex].getAttribute('data-nombre');
            document.getElementById('categoria').value = categoriaNombre;
        }

        function updateMarca(select) {
            var marcaNombre = select.options[select.selectedIndex].getAttribute('data-nombre');
            document.getElementById('marca').value = marcaNombre;
        }

        // Mostrar notificación
        function showNotification(message) {
            var notification = document.getElementById('notification');
            document.getElementById('notification-message').textContent = message;
            notification.style.display = 'block';
        }

        // Cerrar notificación
        document.getElementById('notification-close').onclick = function() {
            document.getElementById('notification').style.display = 'none';
            document.getElementById('product-form').reset(); // Limpiar el formulario
        };

        // Manejar envío del formulario
        document.getElementById('product-form').onsubmit = function(event) {
            event.preventDefault(); // Prevenir el envío por defecto del formulario

            // Usar fetch para enviar el formulario de manera asíncrona
            var formData = new FormData(this);
            fetch(this.action, {
                method: 'POST',
                body: formData
            }).then(response => response.text())
              .then(result => {
                if (result.includes('Producto registrado exitosamente')) {
                    showNotification('Producto registrado exitosamente.');
                } else {
                    showNotification('Error al registrar el producto.');
                }
              });
        };
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Inventario</title>
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

        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-wrapper {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            width: 100%;
            max-width: 900px;
        }

        .register-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 400px;
            width: 100%;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Estilos de los campos de entrada */
        .input-box {
            margin-bottom: 20px;
        }

        .input-box label {
            display: block;
            font-size: 16px;
            color: #333;
            margin-bottom: 5px;
        }

        .input-box input,
        .input-box select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .input-box input:focus,
        .input-box select:focus {
            outline: none;
            border-color: #6200ee;
        }

        /* Botones */
        .button-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        button[type="submit"],
        .view-table-button {
            background-color: #6200ee;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
        }

        button[type="submit"]:hover,
        .view-table-button:hover {
            background-color: #3700b3;
        }

        /* Añadir espacio entre los botones */
        .view-table-button {
            margin-left: 20px;
        }

        /* Notificación */
        .notification {
            background-color: #ffcc00;
            color: #333;
            padding: 15px;
            margin-right: 20px;
            border-radius: 5px;
            text-align: center;
            display: none;
            width: 250px;
            position: relative;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .notification-close {
            position: absolute;
            top: 10px;
            right: 15px;
            cursor: pointer;
            font-size: 20px;
            color: #333;
        }

        .notification-close:hover {
            color: #6200ee;
        }

        /* Media Queries para pantallas pequeñas */
        @media (max-width: 480px) {
            .register-container {
                padding: 20px;
            }

            button[type="submit"],
            .view-table-button {
                width: 100%;
                margin-top: 10px;
            }

            .notification {
                position: static;
                margin-bottom: 20px;
                width: 100%;
            }
        }

    </style>
</head>
<body>
    <div class="register-wrapper">
        <!-- Notificación -->
        <div id="notification" class="notification">
            <span id="notification-message"></span>
            <span id="notification-close" class="notification-close">&times;</span>
        </div>
        <a href="dashboard.php" class="return-button">
    <i class="fa fa-arrow-left"></i> Regresar
</a>

        <div class="register-container">
            <h1>Registrar Inventario</h1>

            <form id="inventory-form" method="POST" action="save_inventory.php" enctype="multipart/form-data">
                <!-- Campos del formulario -->
                <div class="input-box">
                    <label for="id_producto">Producto:</label>
                    <select id="id_producto" name="id_producto" required>
                        <option value="">Selecciona un producto</option>
                        <?php
                        include 'db_connection.php';
                        $result = $conn->query("SELECT id_producto, nombre_producto FROM producto");
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id_producto'] . "'>" . $row['nombre_producto'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="input-box">
                    <label for="entradas">Entradas:</label>
                    <input type="number" id="entradas" name="entradas" required>
                </div>

                <div class="input-box">
                    <label for="salidas">Salidas:</label>
                    <input type="number" id="salidas" name="salidas" required>
                </div>

                <div class="input-box">
                    <label for="fecha">Fecha:</label>
                    <input type="date" id="fecha" name="fecha" required>
                </div>

                <div class="button-container">
                    <button type="submit">Registrar Inventario</button>
                    <a href="view_inventory.php" class="view-table-button">Ver Inventario</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Mostrar notificación
        function showNotification(message) {
            var notification = document.getElementById('notification');
            document.getElementById('notification-message').textContent = message;
            notification.style.display = 'block';
        }

        // Cerrar notificación
        document.getElementById('notification-close').onclick = function() {
            document.getElementById('notification').style.display = 'none';
            document.getElementById('inventory-form').reset(); // Limpiar el formulario
        };

        // Manejar envío del formulario
        document.getElementById('inventory-form').onsubmit = function(event) {
            event.preventDefault(); // Prevenir el envío por defecto del formulario

            // Usar fetch para enviar el formulario de manera asíncrona
            var formData = new FormData(this);
            fetch(this.action, {
                method: 'POST',
                body: formData
            }).then(response => response.text())
              .then(result => {
                if (result.includes('Inventario registrado exitosamente')) {
                    showNotification('Inventario registrado exitosamente.');
                } else {
                    showNotification('Error al registrar el inventario.');
                }
              });
        };
    </script>
</body>
</html>

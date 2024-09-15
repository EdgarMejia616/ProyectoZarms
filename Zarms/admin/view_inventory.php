<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Inventario</title>
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

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: auto;
        }

        .view-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 1000px;
            margin: 20px;
            box-sizing: border-box;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
        }

        .input-box {
            margin-bottom: 20px;
            text-align: center;
        }

        .input-box label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .input-box input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #218838;
        }

        .table-container {
            width: 100%;
            max-height: 400px;
            overflow-y: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
            table-layout: fixed;
        }

        table th, table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #f4f4f4;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table img {
            max-width: 100px;
            height: auto;
            border-radius: 4px;
        }

        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            display: none;
            flex-direction: column;
            align-items: center;
            z-index: 1000;
            width: 90%;
            max-width: 600px;
            box-sizing: border-box;
        }

        .modal-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 500;
            display: none;
        }

        .close-modal {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 50%;
            padding: 5px;
            cursor: pointer;
            font-size: 18px;
            line-height: 1;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
            width: 100%;
        }

        .button-group button {
            width: auto; /* Ajustar el ancho del botón "Modificar" */
            margin-bottom: 20px; /* Reducir el espacio entre el botón y el campo */
        }

        #modify-form button, #delete-form button {
            margin: 0; /* Asegura que no haya márgenes adicionales */
        }
    </style>
</head>
<body>
<a href="register_inventory.php" class="return-button">
    <i class="fa fa-arrow-left"></i> Regresar
</a>

    <div class="view-container">
        <h1>Inventario</h1>
        <form method="GET" action="view_inventory.php">
            <div class="input-box" style="display: flex; align-items: center; justify-content: center;">
                <label for="search" style="margin-right: 10px;">Buscar por Nombre de Producto:</label>
                <input type="text" id="search" name="search" style="margin-right: 10px;">
                <button type="submit">Buscar</button>
            </div>
        </form>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID Inventario</th>
                        <th>Nombre Producto</th>
                        <th>Entradas</th>
                        <th>Salidas</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db_connection.php';

                    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

                    // Modificar la consulta SQL para incluir JOIN con la tabla de productos
                    $sql = "SELECT i.id_inventario, i.id_producto, p.nombre_producto, i.entradas, i.salidas, i.fecha
                            FROM inventario i
                            JOIN producto p ON i.id_producto = p.id_producto
                            WHERE p.nombre_producto LIKE '%$search%'
                            ORDER BY i.id_inventario ASC";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr data-id='" . $row['id_inventario'] . "' data-entradas='" . $row['entradas'] . "' data-salidas='" . $row['salidas'] . "'>
                                    <td>" . $row['id_inventario'] . "</td>
                                    <td>" . $row['nombre_producto'] . "</td>
                                    <td>" . $row['entradas'] . "</td>
                                    <td>" . $row['salidas'] . "</td>
                                    <td>" . $row['fecha'] . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No se encontraron registros de inventario.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Formulario emergente -->
    <div class="modal-bg"></div>
    <div class="modal" id="modal">
        <button class="close-modal">X</button>
        <h2>Modificar/Eliminar Inventario</h2>
        <form id="modify-form" method="POST" action="modify_inventory.php">
            <input type="hidden" id="inventory-id" name="inventory-id">
            <label for="new-entradas">Nuevas Entradas:</label>
            <input type="number" id="new-entradas" name="new-entradas">
            <br>
            <br>
            <label for="new-salidas">Nuevas Salidas:</label>
            <input type="number" id="new-salidas" name="new-salidas">
            <br>
            <div class="button-group">
                <button type="submit">Modificar</button>
                <form id="delete-form" method="POST" action="delete_inventory.php">
                    <input type="hidden" id="delete-inventory-id" name="inventory-id">
                    <button type="submit" style="background-color: red; color: white;">Eliminar</button>
                </form>
            </div>
        </form>
    </div>

    <script>
        const rows = document.querySelectorAll('table tbody tr');
        const modal = document.getElementById('modal');
        const modalBg = document.querySelector('.modal-bg');
        const closeModalBtn = document.querySelector('.close-modal');

        let timer;

        rows.forEach(row => {
            row.addEventListener('mousedown', (event) => {
                timer = setTimeout(() => {
                    const id = row.dataset.id;
                    const entradas = row.dataset.entradas;
                    const salidas = row.dataset.salidas;

                    document.getElementById('inventory-id').value = id;
                    document.getElementById('delete-inventory-id').value = id;
                    document.getElementById('new-entradas').value = entradas;
                    document.getElementById('new-salidas').value = salidas;

                    modal.style.display = 'flex';
                    modalBg.style.display = 'block';
                }, 300);
            });

            row.addEventListener('mouseup', () => {
                clearTimeout(timer);
            });
        });

        closeModalBtn.addEventListener('click', () => {
            modal.style.display = 'none';
            modalBg.style.display = 'none';
        });

        modalBg.addEventListener('click', () => {
            modal.style.display = 'none';
            modalBg.style.display = 'none';
        });
    </script>
</body>
</html>

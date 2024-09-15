<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Productos</title>
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

        .input-box input,
        .input-box select,
        .input-box textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
            box-sizing: border-box;
        }

        .input-box textarea {
            height: 100px;
            resize: vertical;
        }

        /* Botones */
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

        .view-table-button {
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
        }

        .view-table-button:hover {
            background-color: #0056b3;
        }

        .input-box button {
            width: auto;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .input-box button:hover {
            background-color: #0056b3;
        }

        /* Estilos del contenedor de la tabla */
        .table-container {
            width: 100%;
            max-height: 400px;
            overflow-y: auto;
        }

        /* Estilos de la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
            table-layout: fixed;
        }

        table th,
        table td {
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
/* Estilos del formulario emergente */
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

.modal input {
    margin-bottom: 10px;
}

.modal button {
    width: auto;
    padding: 10px;
    background-color: #007bff;
    border: none;
    color: white;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    margin-top: 10px;
}

.modal button:hover {
    background-color: #0056b3;
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

.close-modal:hover {
    background-color: darkred;
}

/* Fondo oscuro cuando modal está activo */
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

/* Estilos para los botones en el grupo */
.button-group {
    display: flex;
    gap: 10px; /* Espacio entre los botones */
    margin-top: 10px;
}


    </style>
</head>
<body>
<a href="register_product.php" class="return-button">
    <i class="fa fa-arrow-left"></i> Regresar
</a>

    <div class="view-container">
        <h1>Lista de Productos</h1>
        <form method="GET" action="view_products.php">
            <div class="input-box" style="display: flex; align-items: center; justify-content: center;">
                <label for="search" style="margin-right: 10px;">Buscar por Nombre:</label>
                <input type="text" id="search" name="search" style="margin-right: 10px;">
                <button type="submit">Buscar</button>
            </div>
        </form>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Categoría</th>
                        <th>Marca</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Estado</th>
                        <th>Proveedor</th>
                        <th>Imagen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db_connection.php';

                    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

                    $sql = "SELECT p.id_producto, p.nombre_producto, p.precio, c.categoria, m.marca, p.descripcion, p.cantidad, p.estado, pr.nombre, p.imagen
                            FROM producto p
                            JOIN categoria c ON p.categoria_id = c.categoria_id
                            JOIN marca m ON p.marca_id = m.marca_id
                            JOIN proveedor pr ON p.id_proveedor = pr.id_proveedor
                            WHERE p.nombre_producto LIKE '%$search%'
                            ORDER BY p.id_producto ASC";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr data-id='" . $row['id_producto'] . "' data-precio='" . $row['precio'] . "' data-cantidad='" . $row['cantidad'] . "'>
                                    <td>" . $row['id_producto'] . "</td>
                                    <td>" . $row['nombre_producto'] . "</td>
                                    <td>" . $row['precio'] . "</td>
                                    <td>" . $row['categoria'] . "</td>
                                    <td>" . $row['marca'] . "</td>
                                    <td>" . $row['descripcion'] . "</td>
                                    <td>" . $row['cantidad'] . "</td>
                                    <td>" . $row['estado'] . "</td>
                                    <td>" . $row['nombre'] . "</td>
                                    <td><img src='" . $row['imagen'] . "' alt='Imagen del producto'></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>No se encontraron productos.</td></tr>";
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
    <h2>Modificar/Eliminar Producto</h2>
    <form id="modify-form" method="POST" action="modify_product.php">
        <input type="hidden" id="product-id" name="product-id">
        <label for="new-price">Nuevo Precio:</label>
        <input type="number" id="new-price" name="new-price">
        <br> <!-- Salto de línea añadido -->
        <label for="new-quantity">Nueva Cantidad:</label>
        <input type="number" id="new-quantity" name="new-quantity">
        <br> <!-- Salto de línea añadido -->
        <div class="button-group">
            <button type="submit">Modificar</button>
            <form id="delete-form" method="POST" action="delete_product.php">
                <input type="hidden" id="delete-product-id" name="product-id">
                <button type="submit" style="background-color: red;">Eliminar</button>
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
                    const precio = row.dataset.precio;
                    const cantidad = row.dataset.cantidad;

                    document.getElementById('product-id').value = id;
                    document.getElementById('new-price').value = precio;
                    document.getElementById('new-quantity').value = cantidad;
                    document.getElementById('delete-product-id').value = id;

                    modal.style.display = 'flex';
                    modalBg.style.display = 'block';
                }, 2000); // 2 segundos para mantener presionado
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
 
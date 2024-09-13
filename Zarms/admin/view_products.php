<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Productos</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
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
            max-height: 400px; /* Ajusta esta altura según tu necesidad */
            overflow-y: auto; /* Añade desplazamiento vertical si es necesario */
        }

        /* Estilos de la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
            table-layout: fixed; /* Asegura que las columnas se mantengan en un tamaño adecuado */
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
    </style>
</head>
<body>
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
                        <th>Imagen</th> <!-- Nueva columna para la imagen -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db_connection.php';

                    // Obtener término de búsqueda si existe
                    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

                    // Consultar productos y ordenar por ID de menor a mayor
                    $sql = "SELECT p.id_producto, p.nombre_producto, p.precio, c.categoria, m.marca, p.descripcion, p.cantidad, p.estado, pr.nombre, p.imagen
                            FROM producto p
                            JOIN categoria c ON p.categoria_id = c.categoria_id
                            JOIN marca m ON p.marca_id = m.marca_id
                            JOIN proveedor pr ON p.id_proveedor = pr.id_proveedor
                            WHERE p.nombre_producto LIKE '%$search%'
                            ORDER BY p.id_producto ASC"; // Ordenar por ID en orden ascendente

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row['id_producto'] . "</td>
                                    <td>" . $row['nombre_producto'] . "</td>
                                    <td>" . $row['precio'] . "</td>
                                    <td>" . $row['categoria'] . "</td>
                                    <td>" . $row['marca'] . "</td>
                                    <td>" . $row['descripcion'] . "</td>
                                    <td>" . $row['cantidad'] . "</td>
                                    <td>" . $row['estado'] . "</td>
                                    <td>" . $row['nombre'] . "</td> <!-- Nombre del proveedor -->
                                    <td><img src='" . $row['imagen'] . "' alt='Imagen del producto'></td> <!-- Imagen del producto -->
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
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Ventas</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 135vh;
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

        .input-box select,
        .input-box input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
            box-sizing: border-box;
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

        /* Estilos del apartado de ventas mensuales */
        .monthly-sales-container {
            margin-top: 20px;
            text-align: center;
        }

        .monthly-sales-container h2 {
            margin-bottom: 10px;
            color: #333;
        }

        .monthly-sales-container table {
            margin: 0 auto;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }

        .monthly-sales-container table th,
        .monthly-sales-container table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .monthly-sales-container table th {
            background-color: #f4f4f4;
        }
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

    <div class="view-container">
        <h1>Detalle de Ventas</h1>

        <!-- Formulario para buscar ventas por mes -->
        <div class="input-box">
            <form method="GET">
                <label for="mes">Selecciona el mes:</label>
                <select id="mes" name="mes">
                    <option value="">--Selecciona un mes--</option>
                    <?php
                    // Opciones de meses
                    $meses = [
                        '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril',
                        '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto',
                        '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
                    ];
                    foreach ($meses as $valor => $nombre) {
                        echo "<option value='$valor'" . ($valor == (isset($_GET['mes']) ? $_GET['mes'] : '') ? ' selected' : '') . ">$nombre</option>";
                    }
                    ?>
                </select>
                <br></br>
                <label for="anio">Selecciona el año:</label>
                <select id="anio" name="anio">
                    <?php
                    // Opciones de años
                    $anio_actual = date("Y");
                    for ($i = 2000; $i <= $anio_actual; $i++) {
                        echo "<option value='$i'" . ($i == (isset($_GET['anio']) ? $_GET['anio'] : '') ? ' selected' : '') . ">$i</option>";
                    }
                    ?>
                </select>
                <br></br>
                <button type="submit">Buscar</button>
            </form>
        </div>

        <!-- Tabla de ventas -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID Venta</th>
                        <th>ID Producto</th>
                        <th>Nombre Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>ID Cliente</th>
                        <th>Fecha</th>
                        <th>Total Venta</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Conexión a la base de datos
                    $servername = "b9adcso2ssjiqbhrwytf-mysql.services.clever-cloud.com";
                    $username = "uzd4kdukd76ffseo";
                    $password = "lXa5hn5RkrINOzg9yDaN";
                    $dbname = "b9adcso2ssjiqbhrwytf";

                    // Crear conexión
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Verificar conexión
                    if ($conn->connect_error) {
                        die("Conexión fallida: " . $conn->connect_error);
                    }

                    // Obtener los parámetros de búsqueda
                    $mes = isset($_GET['mes']) ? $_GET['mes'] : '';
                    $anio = isset($_GET['anio']) ? $_GET['anio'] : '';

                    // Consulta para obtener todas las ventas o filtradas por mes y año
                    $sql = "SELECT id_venta, id_producto, nombre_producto, precio, cantidad, id_cliente, fecha, total_venta FROM venta";
                    if ($mes && $anio) {
                        $sql .= " WHERE DATE_FORMAT(fecha, '%Y-%m') = '$anio-$mes'";
                    }
                    $result = $conn->query($sql);

                    // Verificar si hay resultados
                    if ($result->num_rows > 0) {
                        // Mostrar cada fila de datos
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id_venta"] . "</td>";
                            echo "<td>" . $row["id_producto"] . "</td>";
                            echo "<td>" . $row["nombre_producto"] . "</td>";
                            echo "<td>" . $row["precio"] . "</td>";
                            echo "<td>" . $row["cantidad"] . "</td>";
                            echo "<td>" . $row["id_cliente"] . "</td>";
                            echo "<td>" . $row["fecha"] . "</td>";
                            echo "<td>" . $row["total_venta"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No hay ventas disponibles</td></tr>";
                    }

                    // Cerrar conexión
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Apartado para calcular ventas mensuales -->
        <div class="monthly-sales-container">
            <h2>Ventas por Mes</h2>
            <table>
                <thead>
                    <tr>
                        <th>Mes</th>
                        <th>Año</th>
                        <th>Total Ventas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Reabrir conexión para calcular ventas mensuales
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Verificar conexión
                    if ($conn->connect_error) {
                        die("Conexión fallida: " . $conn->connect_error);
                    }

                    // Obtener los parámetros de búsqueda
                    $mes = isset($_GET['mes']) ? $_GET['mes'] : '';
                    $anio = isset($_GET['anio']) ? $_GET['anio'] : '';

                    // Consulta para calcular ventas mensuales
                    $sql = "SELECT DATE_FORMAT(fecha, '%Y-%m') AS mes_anio, SUM(total_venta) AS total_ventas
                            FROM venta";
                    if ($mes && $anio) {
                        $sql .= " WHERE DATE_FORMAT(fecha, '%Y-%m') = '$anio-$mes'";
                    }
                    $sql .= " GROUP BY DATE_FORMAT(fecha, '%Y-%m')";

                    $result = $conn->query($sql);

                    // Verificar si hay resultados
                    if ($result->num_rows > 0) {
                        // Mostrar cada fila de datos
                        while ($row = $result->fetch_assoc()) {
                            $mes_anio = $row["mes_anio"];
                            $total_ventas = $row["total_ventas"];

                            // Obtener el nombre del mes y año
                            list($anio_venta, $mes_venta) = explode('-', $mes_anio);
                            $nombre_mes = $meses[$mes_venta];
                            echo "<tr>";
                            echo "<td>$nombre_mes</td>";
                            echo "<td>$anio_venta</td>";
                            echo "<td>$total_ventas</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No hay ventas disponibles</td></tr>";
                    }

                    // Cerrar conexión
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

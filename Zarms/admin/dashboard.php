<?php
session_start();

// Verificar si hay un token válido
if (!isset($_SESSION['token']) || !isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
    // Si no está autenticado, redirigir al login
    header('Location: index_admin.php');
    exit();
}

// Datos de conexión a la base de datos
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

// Consultar datos de inventario
$sql = "SELECT p.nombre_producto, c.categoria AS categoria, p.precio, p.marca, p.descripcion, p.cantidad, i.entradas, i.salidas, i.fecha
        FROM inventario i
        JOIN producto p ON i.id_producto = p.id_producto
        JOIN categoria c ON p.categoria_id = c.categoria_id
        ORDER BY i.fecha DESC";
$result = $conn->query($sql);

// Consultar resumen del inventario
$sql_summary = "SELECT COUNT(DISTINCT p.id_producto) AS total_productos, SUM(p.cantidad) AS cantidad_total, SUM(p.precio * p.cantidad) AS valor_total
                FROM producto p";
$summary_result = $conn->query($sql_summary);
$summary = $summary_result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    
    <!-- Incluye Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .dashboard-container {
            display: flex;
            flex-direction: column;
            flex: 1;
            background-color: white;
            padding: 20px;
            margin: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-top: 0;
            color: #333;
            text-align: center;
            font-size: 24px;
        }

        .nav-bar {
            background-color: #007bff;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between; /* Espacia los elementos en la barra de navegación */
            align-items: center;
        }

        .nav-bar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 15px;
        }

        .nav-bar li {
            margin: 0;
        }

        .nav-bar a {
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            transition: background-color 0.3s ease;
        }

        .nav-bar a:hover {
            background-color: #0056b3;
        }

        .nav-bar i {
            margin-right: 8px; /* Espacio entre icono y texto */
        }

        .nav-bar form {
            margin: 0;
        }

        .nav-bar button {
            padding: 10px 20px;
            background-color: #007bff; /* Color azul para el botón de cerrar sesión */
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .nav-bar button:hover {
            background-color: #0056b3;
        }

        .image-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .image-container img {
            width: 80%; /* Ajusta el ancho de la imagen al 80% del contenedor */
            height: auto; /* Mantiene la proporción de la imagen */
            max-width: 600px; /* Establece un ancho máximo para la imagen */
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border-radius: 8px;
            margin-top: auto;
        }

        /* Tarjetas */
        .card {
            background-color: #fff;
            padding: 15px;
            margin: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 18px;
            margin: 0 0 10px;
        }

        .card-content {
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .alert {
            background-color: #ffe0e0;
            padding: 10px;
            margin: 5px 0;
            border-radius: 4px;
        }

        /* Modal */
        .modal {
            display: none; /* Oculta el modal por defecto */
            position: fixed;
            z-index: 1; /* Asegura que el modal esté sobre otros contenidos */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0); /* Fondo oscuro */
            background-color: rgba(0,0,0,0.4); /* Fondo con opacidad */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* Centra el modal en la pantalla */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Ancho del modal */
            max-width: 800px; /* Ancho máximo del modal */
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Responsividad */
        @media (max-width: 768px) {
            .nav-bar ul {
                flex-direction: column;
            }
            .nav-bar a {
                padding: 10px;
                text-align: center;
            }
            .image-container img {
                width: 100%;
                max-width: none;
            }
        }
        
    .nav-bar a {
    text-decoration: none;
    color: white;
    padding: 10px 20px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    transition: background-color 0.3s ease;
}

.nav-bar a:hover {
    background-color: #0056b3;
}

.nav-bar i {
    margin-right: 8px; /* Espacio entre icono y texto */
}

    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Bienvenido al panel de administración</h1>
        <nav class="nav-bar">
            <ul>
                <li><a href="register_product.php"><i class="fas fa-box"></i>Productos</a></li>
                <li><a href="register_inventory.php"><i class="fas fa-warehouse"></i>Inventario</a></li>
                <li><a href="view_orders.php"><i class="fas fa-list-alt"></i>Pedidos</a></li>
                <li><a href="view_ventas.php"><i class="fas fa-chart-line"></i>Ventas</a></li>
                <li><a href="view_compras.php"><i class="fas fa-receipt"></i>Compras</a></li>
                <li><a href="#" id="openModal"><i class="fas fa-info-circle"></i>Resumen de Inventario</a></li>
            </ul>
            <form method="POST" action="logout.php">
                <button type="submit"><i class="fas fa-sign-out-alt"></i>Cerrar Sesión</button>
            </form>
        </nav>
        <!-- Imagen grande debajo de la barra de navegación -->
        <div class="image-container">
            <img src="uploads/logo.jpg" alt="Imagen del Dashboard">
        </div>
        <!-- Ventana Emergente (Modal) -->
        <div id="inventoryModal" class="modal">
            <div class="modal-content">
                <span class="close-btn" id="closeModal">&times;</span>
                <div class="card">
                    <h2 class="card-title">Resumen del Inventario</h2>
                    <div class="card-content">
                        <p><strong>Cantidad Total de Productos:</strong> <?php echo $summary['total_productos']; ?></p>
                        <p><strong>Cantidad Total en Inventario:</strong> <?php echo $summary['cantidad_total']; ?></p>
                        <p><strong>Valor Total del Inventario:</strong> $<?php echo number_format($summary['valor_total'], 2); ?></p>
                    </div>
                </div>
                <div class="card">
                    <h2 class="card-title">Detalles del Inventario</h2>
                    <div class="card-content">
                        <?php if ($result->num_rows > 0): ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Nombre del Producto</th>
                                        <th>Categoría</th>
                                        <th>Marca</th>
                                        <th>Descripción</th>
                                        <th>Cantidad Disponible</th>
                                        <th>Entradas</th>
                                        <th>Salidas</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['nombre_producto']); ?></td>
                                            <td><?php echo htmlspecialchars($row['categoria']); ?></td>
                                            <td><?php echo htmlspecialchars($row['marca']); ?></td>
                                            <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                                            <td><?php echo htmlspecialchars($row['cantidad']); ?></td>
                                            <td><?php echo htmlspecialchars($row['entradas']); ?></td>
                                            <td><?php echo htmlspecialchars($row['salidas']); ?></td>
                                            <td><?php echo htmlspecialchars($row['fecha']); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>No se encontraron registros.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 Mi Empresa. Todos los derechos reservados.</p>
    </footer>

    <script>
        // Obtener el modal
        var modal = document.getElementById('inventoryModal');
        
        // Obtener el botón que abre el modal
        var btn = document.getElementById('openModal');
        
        // Obtener el <span> que cierra el modal
        var span = document.getElementById('closeModal');
        
        // Cuando el usuario hace clic en el botón, abre el modal
        btn.onclick = function() {
            modal.style.display = 'block';
        }
        
        // Cuando el usuario hace clic en <span> (x), cierra el modal
        span.onclick = function() {
            modal.style.display = 'none';
        }
        
        // Cuando el usuario hace clic fuera del modal, cierra el modal
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>

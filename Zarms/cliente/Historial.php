<?php
session_start();
include 'db_connection.php'; // Incluir la conexión a la base de datos

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Obtener el ID del usuario activo
$user_id = $_SESSION['user_id'];

// Consulta para obtener los pedidos del cliente
$sql = "SELECT p.id_pedido, p.nombre_producto, p.imagen, p.precio, p.cantidad, p.total 
        FROM pedido p 
        WHERE p.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); // Cambiado a 'i' para indicar que es un entero
$stmt->execute();
$result = $stmt->get_result();

// Suponiendo que la ruta de las imágenes es 'admin/uploads/'
$image_path = 'http://localhost/Zarms/admin/';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Pedidos</title>
    <link rel="stylesheet" href="css/styleindex_cliente.css">
    <link rel="stylesheet" href="css/promocion.css">
    <link rel="stylesheet" href="css/prueba.css">
    <script src="https://kit.fontawesome.com/7b5fb2de65.js" crossorigin="anonymous"></script>
    <style>
        .product-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 16px;
            margin: 16px;
            background-color: #fff;
            text-align: center;
        }

        .product-card img {
            width: 50%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
            margin-bottom: 16px;
        }

        .product-card h3 {
            font-size: 1.5rem;
            margin: 16px 0;
        }

        .product-card p {
            font-size: 1rem;
            margin: 8px 0;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="logo__container">
                <div class="logogg">
                    <img src="img/logo.png" alt="Logo" class="logo-img">
                </div>
            </div>
            <form class="search-form" action="buscar.php" method="get">
                <div class="search-container">
                    <input type="text" id="search-input" name="query" placeholder="Buscar Productos" class="search-input" required>
                    <button type="submit" class="search-button">🔍</button>
                </div>
            </form>
            <nav class="nav">
                <ul>
                    <li><a href="#" class="login-btn">Iniciar Sesión</a></li>
                    <li><a href="carrito.php"><img src="img/carrito.png" alt="Carrito" class="cart-icon"></a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Menú debajo del header -->
    <div class="sub-menu">
        <div class="menu">
            <ul>
                <li><a href="comprar.php" class="menu-button">Comprar</a></li>
                <li><a href="compras_recientes.php" class="menu-button">Compras Recientes</a></li>
                <li><a href="horario_atencion.php" class="menu-button">Horario de Atención</a></li>
                <li><a href="contacto.php" class="menu-button">Contáctanos</a></li>
            </ul>
        </div>
    </div>

    <!-- Sección de historial de pedidos -->
    <div class="section">
        <div class="container">
            <div class="row">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-md-4 col-xs-6">';
                        echo '<div class="product-card">';
                        $image_url = $image_path . htmlspecialchars($row['imagen']);
                        echo '<img src="' . $image_url . '" alt="' . htmlspecialchars($row['nombre_producto']) . '">';
                        echo '<h3>' . htmlspecialchars($row['nombre_producto']) . '</h3>';
                        echo '<p>Cantidad: ' . htmlspecialchars($row['cantidad']) . '</p>';
                        echo '<p>Precio Unitario: L' . htmlspecialchars($row['precio']) . '</p>';
                        echo '<p>Total: L' . htmlspecialchars($row['total']) . '</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No se encontraron pedidos para este cliente.</p>';
                }
                $conn->close();
                ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer id="footer">
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <span class="copyright">
                            &copy; 2024 <span>Verca Shop</span> Todos los derechos reservados.
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>

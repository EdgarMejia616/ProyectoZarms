<?php
$servername = "b9adcso2ssjiqbhrwytf-mysql.services.clever-cloud.com";
$username = "uzd4kdukd76ffseo";
$password = "lXa5hn5RkrINOzg9yDaN";
$dbname = "b9adcso2ssjiqbhrwytf";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener productos de la categoría "Alimentos" y estado "Activo"
$sql = "SELECT nombre_producto, precio, descripcion, imagen, estado FROM producto WHERE categoria = 'Exteriores' AND estado = 'Activo'";
$result = $conn->query($sql);

// Suponiendo que la ruta de las imágenes es 'admin/uploads/'
$image_path = 'http://localhost/Zarms/admin/';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos para Exteriores</title>
    <link rel="stylesheet" href="css/styleindex_cliente.css">
    <link rel="stylesheet" href="css/promocion.css">
    <link rel="stylesheet" href="css/prueba.css">
    <script src="https://kit.fontawesome.com/7b5fb2de65.js" crossorigin="anonymous"></script>
    <style>
        /* Estilo para la sección de productos */
        .product-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 16px;
            margin: 16px;
            background-color: #fff;
            text-align: center;
        }

        /* Estilo para las imágenes de los productos */
        .product-card img {
            width: 100%;
            height: 200px; /* Ajusta la altura según sea necesario */
            object-fit: cover; /* Ajusta la imagen para cubrir el área sin distorsionar */
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

        .cta-btn {
            background-color: #5cb85c;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .cta-btn:hover {
            background-color: #4cae4c;
        }

        /* Estilo para la sección */
        .section {
            background-color: #f9f9f9;
            padding: 40px 0;
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
    <input type="text" id="search-input" name="query" placeholder="Buscar Alimentos" class="search-input" required>
    <button type="button" class="clear-button" onclick="clearSearch()">✖</button>
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

    <!-- Sección de productos -->
    <div class="section">
        <div class="container">
            <div class="row">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-md-4 col-xs-6">';
                        echo '<div class="product-card">';
                        // Construye la URL de la imagen
                        $image_url = $image_path . htmlspecialchars($row['imagen']);
                        echo '<img src="' . $image_url . '" alt="' . htmlspecialchars($row['nombre_producto']) . '">';
                        echo '<h3>' . htmlspecialchars($row['nombre_producto']) . '</h3>';
                        echo '<p>' . htmlspecialchars($row['descripcion']) . '</p>';
                        echo '<p>Precio: L' . htmlspecialchars($row['precio']) . '</p>';
                        echo '<p>Estado: ' . htmlspecialchars($row['estado']) . '</p>';
                        echo '<a href="carrito.php?nombre_producto=' . urlencode($row['nombre_producto']) . '&precio=' . urlencode($row['precio']) . '&imagen=' . urlencode($row['imagen']) . '" class="cta-btn">Comprar ahora <i class="fa fa-arrow-circle-right"></i></a>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No se encontraron productos.</p>';
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
                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">About Us</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.</p>
                            <ul class="footer-links">
                                <li><a href="#"><i class="fa fa-map-marker"></i>1734 Stonecoal Road</a></li>
                                <li><a href="#"><i class="fa fa-phone"></i>+021-95-51-84</a></li>
                                <li><a href="#"><i class="fa fa-envelope-o"></i>email@email.com</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Categories</h3>
                            <ul class="footer-links">
                                <li><a href="#">Hot deals</a></li>
                                <li><a href="#">Laptops</a></li>
                                <li><a href="#">Smartphones</a></li>
                                <li><a href="#">Cameras</a></li>
                                <li><a href="#">Accessories</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix visible-xs"></div>
                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Information</h3>
                            <ul class="footer-links">
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Orders and Returns</a></li>
                                <li><a href="#">Terms & Conditions</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Service</h3>
                            <ul class="footer-links">
                                <li><a href="#">My Account</a></li>
                                <li><a href="#">View Cart</a></li>
                                <li><a href="#">Wishlist</a></li>
                                <li><a href="#">Track My Order</a></li>
                                <li><a href="#">Help</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="bottom-footer" class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <ul class="footer-payments">
                            <li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
                            <li><a href="#"><i class="fa fa-credit-card"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
                        </ul>
                        <span class="copyright">
                            &copy; 2024 <span>Verca Shop</span> All Rights Reserved.
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
<script>
  function clearSearch() {
    // Almacena un estado en el localStorage para indicar que el campo debe ser limpiado
    localStorage.setItem('clearSearch', 'true');
    // Redirige a la página anterior en el historial del navegador
    window.history.back();
  }

  // Función para limpiar el campo de búsqueda cuando la página se carga
  function initializeSearch() {
    if (localStorage.getItem('clearSearch') === 'true') {
      // Limpia el campo de búsqueda
      document.getElementById('search-input').value = '';
      // Borra el estado del localStorage
      localStorage.removeItem('clearSearch');
    }
  }

  // Llama a initializeSearch cuando la página se carga
  window.onload = initializeSearch;
</script>


</html>

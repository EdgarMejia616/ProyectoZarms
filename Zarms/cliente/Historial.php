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
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Historial de Pedidos</title>
    <script
      src="https://kit.fontawesome.com/7b5fb2de65.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="css/promocion.css" />
    <link rel="stylesheet" href="css/prueba.css" />
    <link rel="stylesheet" href="css/styleindex_cliente.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="css/style.css" rel="stylesheet">

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
    width: 100%;
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
 

<!--prueba dillan   -->
 <!-- Topbar Start -->
 <div class="container-fluid">
        <div class="row bg-secondary py-1 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center h-100">
                    <a class="text-body mr-3" href="">About</a>
                    <a class="text-body mr-3" href="">Contact</a>
                    <a class="text-body mr-3" href="">Help</a>
                    <a class="text-body mr-3" href="">FAQs</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">My Account</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">Sign in</button>
                            <button class="dropdown-item" type="button">Sign up</button>
                        </div>
                    </div>
                    <div class="btn-group mx-2">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">USD</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">EUR</button>
                            <button class="dropdown-item" type="button">GBP</button>
                            <button class="dropdown-item" type="button">CAD</button>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">EN</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">FR</button>
                            <button class="dropdown-item" type="button">AR</button>
                            <button class="dropdown-item" type="button">RU</button>
                        </div>
                    </div>
                </div>
                <div class="d-inline-flex align-items-center d-block d-lg-none">
                    <a href="" class="btn px-0 ml-2">
                        <i class="fas fa-heart text-dark"></i>
                        <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
                    </a>
                    <a href="" class="btn px-0 ml-2">
                        <i class="fas fa-shopping-cart text-dark"></i>
                        <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
            <div class="col-lg-4">
                <a href="" class="text-decoration-none">
                    <span class="h1 text-uppercase text-primary bg-dark px-2">ZAR</span>
                    <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">MS</span>
                </a>
            </div>
            <div class="col-lg-4 col-6 text-left">


                <form class="search-form" action="buscar.php" method="get">
                    <div class="input-group">
                        <input type="text" id="search-input" name="query" class="form-control" placeholder="Buscar producto " class="search-input" required>
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 col-6 text-right">
                <p class="m-0">Customer Service</p>
                <h5 class="m-0">+012 345 6789</h5>
            </div>
        </div>
    </div>

     <!-- Navbar Start -->
     <div class="container-fluid bg-dark mb-30">
        <div class="row px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
    <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
    <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Categorías</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                <div class="navbar-nav w-100">
                    <a href="Alimentos.php" class="nav-item nav-link">
                        <i class="fas fa-apple-alt mr-2"></i> Alimentos
                    </a>
                    <a href="bebe.php" class="nav-item nav-link">
                        <i class="fas fa-baby mr-2"></i> Bebé
                    </a>
                    <a href="Alcohol.php" class="nav-item nav-link">
                        <i class="fas fa-wine-glass-alt mr-2"></i> Alcohol
                    </a>
                    <a href="belleza.php" class="nav-item nav-link">
                        <i class="fas fa-magic mr-2"></i> Belleza
                    </a>
                    <a href="Electrodomesticos.php" class="nav-item nav-link">
                        <i class="fas fa-blender mr-2"></i> Electrodomésticos
                    </a>
                    <a href="logout.php" class="nav-item nav-link">
                        <i class="fas fa-sign-out-alt text-primary"></i> Cerrar Sesion
                    </a>
        </div>
    </nav>
</div>
<!-- Enlaza jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Enlaza Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <span class="h1 text-uppercase text-dark bg-light px-2">Multi</span>
                        <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Shop</span>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="index_cliente.php" class="nav-item nav-link active">Inicio</a>
                            <a href="shop.php" class="nav-item nav-link">Lista de Productos</a>
                            <a href="checkout.php" class="nav-item nav-link">Carrito</a>
                            <a href="Historial.php" class="nav-item nav-link">Pedidos</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages <i class="fa fa-angle-down mt-1"></i></a>
                                <div class="dropdown-menu bg-primary rounded-0 border-0 m-0">
                                    <a href="carrito.php" class="dropdown-item">Shopping Cart</a>
                                    <a href="checkout.html" class="dropdown-item">Checkout</a>
                                </div>
                            </div>
                            <a href="contact.html" class="nav-item nav-link">Contacto</a>
                        </div>
                        
                        <?php
// Establece la conexión a la base de datos
$servername = "b9adcso2ssjiqbhrwytf-mysql.services.clever-cloud.com";
$username = "uzd4kdukd76ffseo";
$password = "lXa5hn5RkrINOzg9yDaN";
$dbname = "b9adcso2ssjiqbhrwytf";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

/**
 * Cuenta la cantidad de productos en el carrito desde la base de datos.
 *
 * @param mysqli $conn La conexión a la base de datos.
 * @return int Cantidad total de productos en el carrito.
 */
function countProductsInCart($conn) {
    $sql = "SELECT SUM(cantidad) AS total FROM carrito"; // Sumar la cantidad de productos en el carrito
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        return (int)$row['total']; // Retorna el total
    }

    return 0; // Retorna 0 si no se encuentran productos
}

try {
    // Contar los productos en el carrito
    $total_products = countProductsInCart($conn);
} catch (Exception $e) {
    // Manejo de errores
    echo "Error al contar los productos: " . $e->getMessage();
    $total_products = 0; // Asegúrate de establecer un valor predeterminado
} 
?>
<div class="navbar-nav ml-auto py-0 d-none d-lg-block">
    <a href="carrito.php" class="btn px-0 ml-3">
        <i class="fas fa-shopping-cart text-primary"></i>
        <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">
            <?php echo htmlspecialchars($total_products); ?>
        </span>
    </a>
</div>

                    </div>
                </nav>
            </div>
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

   
<!--footer -->
 <!-- Footer Start -->
 <div class="container-fluid bg-dark text-secondary mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <h5 class="text-secondary text-uppercase mb-4">Get In Touch</h5>
                <p class="mb-4">No dolore ipsum accusam no lorem. Invidunt sed clita kasd clita et et dolor sed dolor. Rebum tempor no vero est magna amet no</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Street, New York, USA</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">Quick Shop</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-secondary mb-2" href="index_cliente.php"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-secondary" href="#"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">My Account</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-secondary" href="#"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">Newsletter</h5>
                        <p>Duo stet tempor ipsum sit amet magna ipsum tempor est</p>
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Your Email Address">
                                <div class="input-group-append">
                                    <button class="btn btn-primary">Sign Up</button>
                                </div>
                            </div>
                        </form>
                        <h6 class="text-secondary text-uppercase mt-4 mb-3">Follow Us</h6>
                        <div class="d-flex">
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a class="btn btn-primary btn-square" href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top mx-xl-5 py-4" style="border-color: rgba(256, 256, 256, .1) !important;">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-secondary">
                    &copy; <a class="text-primary" href="#">Domain</a>. All Rights Reserved. Designed Grupo D
                    
                   
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="img/payments.png" alt="">
            </div>
        </div>
    </div>
    <!-- Footer End -->
</body>
</html>

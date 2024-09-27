<?php
session_start();
include 'db_connection.php'; // Incluir la conexión a la base de datos

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    // Si no hay usuario autenticado, redirigir al login
    header('Location: login.php');
    exit();
}

// Obtener el ID del usuario activo desde la sesión
$user_id = $_SESSION['user_id'];

// Conexión a la base de datos
$conn = new mysqli('b9adcso2ssjiqbhrwytf-mysql.services.clever-cloud.com', 'uzd4kdukd76ffseo', 'lXa5hn5RkrINOzg9yDaN', 'b9adcso2ssjiqbhrwytf');

// Verifica si la conexión fue exitosa
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta para obtener los productos pendientes del pedido del usuario conectado
$sql = "SELECT id_pedido, nombre_producto, total FROM pedido WHERE id = ? AND estado = 'pendiente'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); // 'i' indica que estamos pasando un valor entero
$stmt->execute();
$result = $stmt->get_result();

// Inicializamos el subtotal
$subtotal = 0;
$productos = [];

// Recorremos los productos del pedido y calculamos el subtotal
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
    $subtotal += $row['total'];
}


$envio = 10; // Envío fijo de $10
$total = $subtotal + $envio;

// Cuando el formulario se envía (el usuario hizo clic en "Place Order")
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $direccion1 = $_POST['direccion1'];
    $direccion2 = $_POST['direccion2'];
    $pais = $_POST['pais'];
    $ciudad = $_POST['ciudad'];
    $estado = $_POST['estado'];
    $codigo_postal = $_POST['codigo_postal'];

    // Inserción en la tabla Checkout
    $sql_checkout = "INSERT INTO Checkout (nombre, apellido, correo, telefono, direccion1, direccion2, pais, ciudad, estado, codigo_postal, total)
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt_checkout = $conn->prepare($sql_checkout);
    $stmt_checkout->bind_param("ssssssssssd", $nombre, $apellido, $correo, $telefono, $direccion1, $direccion2, $pais, $ciudad, $estado, $codigo_postal, $total);

    if ($stmt_checkout->execute()) {
        // Actualizar el estado de los pedidos del usuario a "completado"
        $sql_update = "UPDATE pedido SET estado = 'completado' WHERE id = ? AND estado = 'pendiente'";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("i", $user_id);
        $stmt_update->execute();

        echo "Checkout completado exitosamente.";
    } else {
        echo "Error: " . $conn->error;
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Zarms - Compras en linea</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">  

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    
</head>

<body>
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
                <a href="index_cliente.php" class="text-decoration-none">
                    <span class="h1 text-uppercase text-primary bg-dark px-2">ZAR</span>
                    <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">MS</span>
                </a>
            </div>
            <div class="col-lg-4 col-6 text-left">
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for products">
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
    <!-- Topbar End -->


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
                        <span class="h1 text-uppercase text-dark bg-light px-2">ZAR</span>
                        <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">MS</span>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="index_cliente.php" class="nav-item nav-link">Inicio</a>
                            <a href="shop.php" class="nav-item nav-link">Lista de producto</a>
                            <a href="Historial.php" class="nav-item nav-link">Pedidos</a>
                            <a href="carrito.php" class="nav-item nav-link">Carrito</a>
                            <a href="contact.html" class="nav-item nav-link">Contacto</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                            <a href="" class="btn px-0">
                                <i class="fas fa-heart text-primary"></i>
                                <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">0</span>
                            </a>
                            <a href="" class="btn px-0 ml-3">
                                <i class="fas fa-shopping-cart text-primary"></i>
                                <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">0</span>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->


    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">Checkout</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <h5 class="section-title position-relative text-uppercase mb-3">
                <span class="bg-secondary pr-3">Billing Address</span>
            </h5>
            <div class="bg-light p-30 mb-5">
                <form action="checkout.php" method="POST">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>First Name</label>
                            <input class="form-control" type="text" name="nombre" placeholder="John" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Last Name</label>
                            <input class="form-control" type="text" name="apellido" placeholder="Doe" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" type="email" name="correo" placeholder="example@email.com" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Mobile No</label>
                            <input class="form-control" type="text" name="telefono" placeholder="+123 456 789" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 1</label>
                            <input class="form-control" type="text" name="direccion1" placeholder="123 Street" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 2</label>
                            <input class="form-control" type="text" name="direccion2" placeholder="123 Street">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Country</label>
                            <select class="custom-select" name="pais" required>
                                <option value="United States" selected>United States</option>
                                <option value="Afghanistan">Afghanistan</option>
                                <option value="Albania">Albania</option>
                                <option value="Algeria">Algeria</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>City</label>
                            <input class="form-control" type="text" name="ciudad" placeholder="New York" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>State</label>
                            <input class="form-control" type="text" name="estado" placeholder="New York" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>ZIP Code</label>
                            <input class="form-control" type="text" name="codigo_postal" placeholder="123" required>
                        </div>
                    </div>

                    <br>

                    <!-- Resumen del Pedido -->
                    <h5 class="section-title position-relative text-uppercase mb-3">
                        <span class="bg-secondary pr-3">Order Total</span>
                    </h5>
                    <div class="bg-light p-30 mb-5">
                        <div class="border-bottom">
                            <h6 class="mb-3">Products</h6>
                            <?php foreach ($productos as $producto): ?>
                                <div class="d-flex justify-content-between">
                                    <p><?php echo htmlspecialchars($producto['nombre_producto']); ?></p>
                                    <p>$<?php echo number_format($producto['total'], 2); ?></p>
                                </div>
                                <input type="hidden" name="productos[]" value="<?php echo $producto['nombre_producto']; ?>">
                                <input type="hidden" name="precios[]" value="<?php echo $producto['total']; ?>">
                            <?php endforeach; ?>
                        </div>

                        <div class="border-bottom pt-3 pb-2">
                            <div class="d-flex justify-content-between mb-3">
                                <h6>Subtotal</h6>
                                <h6>$<?php echo number_format($subtotal, 2); ?></h6>
                                <input type="hidden" name="subtotal" value="<?php echo $subtotal; ?>">
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Shipping</h6>
                                <h6 class="font-weight-medium">$<?php echo number_format($envio, 2); ?></h6>
                                <input type="hidden" name="envio" value="<?php echo $envio; ?>">
                            </div>
                        </div>

                        <div class="pt-2">
                            <div class="d-flex justify-content-between mt-2">
                                <h5>Total</h5>
                                <h5>$<?php echo number_format($total, 2); ?></h5>
                                <input type="hidden" name="total" value="<?php echo $total; ?>">
                            </div>
                        </div>
                    </div>

                    <br>

                    <!-- Métodos de Pago -->
                    <div class="mb-5">
                        <h5 class="section-title position-relative text-uppercase mb-3">
                            <span class="bg-secondary pr-3">Payment</span>
                        </h5>
                        <div class="bg-light p-30">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment" id="paypal" value="Paypal" required>
                                    <label class="custom-control-label" for="paypal">Paypal</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment" id="directcheck" value="Direct Check" required>
                                    <label class="custom-control-label" for="directcheck">Direct Check</label>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment" id="banktransfer" value="Bank Transfer" required>
                                    <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-block btn-primary font-weight-bold py-3">Place Order</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


                
            </div>
        </div>
    </div>
    <!-- Checkout End -->


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
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Home</a>
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
                    &copy; <a class="text-primary" href="#">Domain</a>. All Rights Reserved. Designed
                    by
                    <a class="text-primary" href="https://htmlcodex.com">HTML Codex</a>
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="img/payments.png" alt="">
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
<?php
// Establecer conexión a la base de datos
$servername = "b9adcso2ssjiqbhrwytf-mysql.services.clever-cloud.com";
$username = "uzd4kdukd76ffseo";
$password = "lXa5hn5RkrINOzg9yDaN";
$dbname = "b9adcso2ssjiqbhrwytf";
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Definir el filtro de precio
$precio_filtro = isset($_GET['precio']) ? $_GET['precio'] : ['all'];

// Generar la condición SQL basada en el filtro de precio seleccionado
$price_conditions = [];

if (!in_array('all', $precio_filtro)) {
    foreach ($precio_filtro as $rango) {
        list($min_price, $max_price) = explode('-', $rango);
        $min_price = (int) $min_price;
        $max_price = (int) $max_price;
        $price_conditions[] = "(precio >= $min_price AND precio <= $max_price)";
    }
}

// Construir la consulta SQL
$sql = "SELECT * FROM producto";
if (!empty($price_conditions)) {
    $sql .= " WHERE " . implode(" OR ", $price_conditions);
}

// Ejecutar la consulta
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    <link rel="stylesheet" href="css/promocion.css" />
    <link rel="stylesheet" href="css/prueba.css" />
    <link rel="stylesheet" href="css/styleindex_cliente.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="css/style.css" rel="stylesheet">
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
<div class="navbar-nav ml-auto py-0 d-none d-lg-block d-flex" style="gap: 10px;">
    <a href="carrito.php" class="btn px-0">
        <i class="fas fa-shopping-cart text-primary"></i>
        <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">
            <?php echo htmlspecialchars($total_products); ?>
        </span>
    </a>    
    <a href="logout.php" class="btn px-0">
        <i class="fas fa-sign-out-alt text-primary"></i>
    </a>
</div>

                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->

    <!-- prelista Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="#">Home</a>
                <a class="breadcrumb-item text-dark" href="#">Shop</a>
                <span class="breadcrumb-item active">Shop List</span>
            </nav>
        </div>
    </div>
</div>
<!-- prelista End -->

<!-- inicio de compra Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-4">
            <!-- Price Filter Start -->
            <h5 class="section-title position-relative text-uppercase mb-3">
                <span class="bg-secondary pr-3">Filtrar por Precio</span>
            </h5>
            <div class="bg-light p-4 mb-30">
                <form method="GET" action="filtrar_productos.php">
                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
    <input type="checkbox" class="custom-control-input" id="price-all" name="precio[]" value="all" checked>
    <label class="custom-control-label" for="price-all">Todos los precios</label>
    <span class="badge border font-weight-normal">1000</span>
</div>
<div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
    <input type="checkbox" class="custom-control-input" id="price-1" name="precio[]" value="0-100">
    <label class="custom-control-label" for="price-1">L0 - L100</label>
    <span class="badge border font-weight-normal">150</span>
</div>
<div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
    <input type="checkbox" class="custom-control-input" id="price-2" name="precio[]" value="100-200">
    <label class="custom-control-label" for="price-2">L100 - L200</label>
    <span class="badge border font-weight-normal">295</span>
</div>
<div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
    <input type="checkbox" class="custom-control-input" id="price-3" name="precio[]" value="200-300">
    <label class="custom-control-label" for="price-3">L200 - L300</label>
    <span class="badge border font-weight-normal">246</span>
</div>
<div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
    <input type="checkbox" class="custom-control-input" id="price-4" name="precio[]" value="300-400">
    <label class="custom-control-label" for="price-4">L300 - L400</label>
    <span class="badge border font-weight-normal">145</span>
</div>
<div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
    <input type="checkbox" class="custom-control-input" id="price-5" name="precio[]" value="400-500">
    <label class="custom-control-label" for="price-5">L400 - L500</label>
    <span class="badge border font-weight-normal">168</span>
</div>
<button type="submit" class="btn btn-primary mt-3">Aplicar Filtros</button>

<!-- JavaScript para manejar la selección de "Todos los precios" -->
<script>
    document.getElementById('price-all').addEventListener('change', function() {
        if (this.checked) {
            document.querySelectorAll('input[name="precio[]"]').forEach(function(checkbox) {
                if (checkbox.id !== 'price-all') {
                    checkbox.checked = false;
                }
            });
        }
    });

    document.querySelectorAll('input[name="precio[]"]').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            if (this.id !== 'price-all' && this.checked) {
                document.getElementById('price-all').checked = false;
            }
        });
    });
</script>

                </form>
            </div>
            <!-- Price Filter End -->
            
            <!-- Color Filter Start -->
            <h5 class="section-title position-relative text-uppercase mb-3">
                <span class="bg-secondary pr-3">Filtrar por color</span>
            </h5>
            <div class="bg-light p-4 mb-30">
                <form>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" checked id="color-all">
                        <label class="custom-control-label" for="color-all">Todos los colores</label>
                        <span class="badge border font-weight-normal">1000</span>
                    </div>
                    <!-- Otros colores -->
                </form>
            </div>
            <!-- Color Filter End -->
            
            <!-- Size Filter Start -->
            <h5 class="section-title position-relative text-uppercase mb-3">
                <span class="bg-secondary pr-3">Filtrar por Tamaño</span>
            </h5>
            <div class="bg-light p-4 mb-30">
                <form>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" checked id="size-all">
                        <label class="custom-control-label" for="size-all">Todos los tamaños</label>
                        <span class="badge border font-weight-normal">1000</span>
                    </div>
                    <!-- Otros tamaños -->
                </form>
            </div>
            <!-- Size Filter End -->
        </div>
        <!-- Shop Sidebar End -->

        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-8">
            <div class="row pb-3">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $image_url = "http://localhost/Zarms/admin/" . htmlspecialchars($row['imagen']);
                        $nombre_producto = str_replace('_', ' ', htmlspecialchars($row['nombre_producto']));
                        $precio = htmlspecialchars($row['precio']);
                        $descripcion = htmlspecialchars($row['descripcion']);
                        ?>
                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                            <div class="product-item bg-light mb-4">
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100" src="<?php echo $image_url; ?>" alt="<?php echo $nombre_producto; ?>">
                                    <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square" href="carrito.php?nombre_producto=<?php echo urlencode($row['nombre_producto']); ?>&precio=<?php echo urlencode($row['precio']); ?>&imagen=<?php echo urlencode($row['imagen']); ?>"><i class="fa fa-shopping-cart"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate" href=""><?php echo $nombre_producto; ?></a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5>L<?php echo $precio; ?></h5>
                                    </div>
                                    <p><?php echo $descripcion; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<p>No se encontraron productos en este rango de precios.</p>';
                }
                $conn->close();
                ?>
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
</div>
<!-- compras fin End -->


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

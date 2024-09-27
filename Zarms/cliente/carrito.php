<?php
// Incluye el archivo de conexión a la base de datos
include 'db_connection.php'; // Asegúrate de que el archivo de conexión se llame 'db_connection.php'

// Verifica si los parámetros del producto están en la URL
if (isset($_GET['nombre_producto']) && isset($_GET['precio']) && isset($_GET['imagen'])) {
    $nombre_producto = $conn->real_escape_string($_GET['nombre_producto']);
    $precio = $conn->real_escape_string($_GET['precio']);
    $imagen = $conn->real_escape_string($_GET['imagen']);

    // Verifica si el producto ya está en el carrito
    $sql_check = "SELECT * FROM carrito WHERE nombre_producto = '$nombre_producto'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows == 0) {
        // Si el producto no está en el carrito, agrégalo
        $sql_insert = "INSERT INTO carrito (nombre_producto, precio, imagen, cantidad) VALUES ('$nombre_producto', '$precio', '$imagen', 1)";
        if ($conn->query($sql_insert) === TRUE) {
            echo "Producto agregado al carrito.";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
         "El producto ya está en el carrito.";
    }
} else {
     "No se recibieron datos del producto.";
}

// Confirmar y procesar el pedido
if (isset($_POST['confirmar'])) {
    // Procesar los datos del carrito
    $sql_select = "SELECT * FROM carrito";
    $result_select = $conn->query($sql_select);

    while ($row = $result_select->fetch_assoc()) {
        $nombre_producto = $conn->real_escape_string($row['nombre_producto']);
        $precio = $conn->real_escape_string($row['precio']);
        $imagen = $conn->real_escape_string($row['imagen']);
        $cantidad = $conn->real_escape_string($row['cantidad']);

        // Buscar el id_producto por nombre_producto
        $sql_get_id = "SELECT id_producto FROM producto WHERE nombre_producto = '$nombre_producto'";
        $result_get_id = $conn->query($sql_get_id);
        if ($result_get_id->num_rows > 0) {
            $row_id = $result_get_id->fetch_assoc();
            $id_producto = $row_id['id_producto'];

            // Insertar en la tabla pedido
            $sql_insert_pedido = "INSERT INTO pedido (id_producto, nombre_producto, imagen, precio, cantidad) VALUES ('$id_producto', '$nombre_producto', '$imagen', '$precio', '$cantidad')";
            $conn->query($sql_insert_pedido);
        }

        // Eliminar del carrito
        $sql_delete = "DELETE FROM carrito WHERE nombre_producto = '$nombre_producto'";
        $conn->query($sql_delete);
    }

    echo "Pedido confirmado y carrito vacío.";
}

// Consulta para obtener los datos del carrito
$sql = "SELECT * FROM carrito";
$result = $conn->query($sql);

// Verifica si la función createValidId ya está definida antes de declararla
if (!function_exists('createValidId')) {
    // Función para crear un ID válido a partir del nombre del producto
    function createValidId($str) {
        return preg_replace('/[^a-zA-Z0-9_]/', '_', $str);
    }
}
$subtotal = 0;

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="css/promocion.css" />
    <link rel="stylesheet" href="css/prueba.css" />
    <link rel="stylesheet" href="css/styleindex_cliente.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="css/style.css" rel="stylesheet">
   
</head>
<body>
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
                            <a href="checkout.php" class="nav-item nav-link">Verificar Pago</a>
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
    <!-- Navbar End -->
     
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">Shopping Cart</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

      <!-- Cart Start -->
<form method="post" action="confirm_order.php">
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Productos</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <!-- PHP loop to display products in cart -->
                        <?php if ($result->num_rows > 0): ?>
                            <?php
                            $subtotal = 0;
                            while($row = $result->fetch_assoc()): 
                                $image_url = 'http://localhost/Zarms/admin/' . htmlspecialchars($row['imagen']);
                                $valid_id = createValidId($row['nombre_producto']);
                                $total = $row['precio'] * $row['cantidad'];
                                $subtotal += $total;
                            ?>
                                <tr>
                                    <td class="align-middle">
                                        <img src="<?php echo $image_url; ?>" alt="" style="width: 50px;">
                                        <?php echo htmlspecialchars($row['nombre_producto']); ?>
                                    </td>
                                    <td class="align-middle">$<?php echo htmlspecialchars($row['precio']); ?></td>
                                    <td class="align-middle">
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-sm btn-primary btn-minus" onclick="changeQuantity('<?php echo $valid_id; ?>', -1)">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" id="quantity_<?php echo $valid_id; ?>" name="quantity_<?php echo $valid_id; ?>" class="form-control form-control-sm bg-secondary border-0 text-center" value="<?php echo htmlspecialchars($row['cantidad']); ?>" data-price="<?php echo htmlspecialchars($row['precio']); ?>">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-sm btn-primary btn-plus" onclick="changeQuantity('<?php echo $valid_id; ?>', 1)">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">$<span id="total_<?php echo $valid_id; ?>"><?php echo number_format($total, 2); ?></span></td>
                                    <td class="align-middle">
                                        <a href="#" class="btn btn-sm btn-danger" onclick="confirmRemove('<?php echo htmlspecialchars($row['nombre_producto']); ?>')">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </td>
                                    <!-- Hidden fields to pass product info to confirm_order.php -->
                                    <input type="hidden" name="nombre_producto[]" value="<?php echo htmlspecialchars($row['nombre_producto']); ?>">
                                    <input type="hidden" id="hidden_total_<?php echo $valid_id; ?>" name="hidden_total_<?php echo $valid_id; ?>" value="<?php echo number_format($total, 2); ?>">
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">No hay productos en el carrito.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <form class="mb-30">
                    <div class="input-group">
                        <input type="text" class="form-control border-0 p-4" placeholder="Coupon Code">
                        <div class="input-group-append">
                        <a href="checkout.php" class="btn btn-primary">Apply Coupon</a>
                        </div>
                    </div>
                </form>
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6>$<span id="cart-subtotal"><?php echo number_format($subtotal, 2); ?></span></h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">$10</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5>$<span id="cart-total"><?php echo number_format($subtotal + 10, 2); ?></span></h5>
                        </div>
                        <button type="submit" name="confirmar" class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceed To Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Cart End -->




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


<script>
function changeQuantity(productId, change) {
    const quantityInput = document.querySelector(`#quantity_${productId}`);
    let quantity = parseInt(quantityInput.value);
    quantity += change;
    if (quantity < 1) quantity = 1;
    quantityInput.value = quantity;

    const price = parseFloat(quantityInput.getAttribute('data-price'));
    const total = price * quantity;

    document.querySelector(`#total_${productId}`).textContent = total.toFixed(2);
    document.querySelector(`#hidden_total_${productId}`).value = total.toFixed(2);

    // Optionally update subtotal and total if you track them dynamically
    updateCartTotals();
}

function confirmRemove(productName) {
    if (confirm(`¿Estás seguro de que quieres eliminar ${productName} del carrito?`)) {
        window.location.href = `remove_from_cart.php?nombre_producto=${encodeURIComponent(productName)}`;
    }
}

// Update cart totals dynamically (if needed)
function updateCartTotals() {
    let subtotal = 0;
    document.querySelectorAll('input[name^="hidden_total_"]').forEach((input) => {
        subtotal += parseFloat(input.value);
    });
    document.querySelector('#cart-subtotal').textContent = subtotal.toFixed(2);
    const shipping = 10;
    const total = subtotal + shipping;
    document.querySelector('#cart-total').textContent = total.toFixed(2);
}
</script>


</body>
</html>
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
        echo "El producto ya está en el carrito.";
    }
} else {
    echo "No se recibieron datos del producto.";
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

// Cerrar la conexión a la base de datos
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="css/styleindex_cliente.css" />
    <link rel="stylesheet" href="css/promocion.css" />
    <link rel="stylesheet" href="css/prueba.css" />
    <style>
        /* Estilo para las tarjetas del carrito */
.product-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 16px;
    margin: 16px;
    background-color: #fff;
    text-align: left; /* Alinea el texto a la izquierda */
    display: flex; /* Usa flexbox para el diseño */
    flex-direction: column; /* Coloca los elementos en una columna */
    align-items: flex-start; /* Alinea los elementos al inicio */
}

.product-card img {
    width: 100%;
    height: 200px; /* Ajusta la altura según sea necesario */
    object-fit: cover; /* Ajusta la imagen para cubrir el área sin distorsionar */
    border-bottom: 1px solid #ddd;
    margin-bottom: 16px;
}

.product-card h3 {
    font-size: 1.5rem;
    margin: 8px 0; /* Reduce el margen superior e inferior */
}

.product-card p {
    font-size: 1rem;
    margin: 4px 0; /* Reduce el margen superior e inferior */
}

h2 {
    text-align: center;
}

.cta-btn {
    background-color: #5cb85c;
    color: #fff;
    padding: 8px 16px; /* Reduce el padding */
    text-decoration: none;
    border-radius: 5px;
    display: inline-block;
    transition: background-color 0.3s;
}

.cta-btn:hover {
    background-color: #4cae4c;
}

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 8px;
}

.quantity-controls button {
    background-color: #ddd;
    border: none;
    border-radius: 4px;
    padding: 4px 8px;
    cursor: pointer;
}

.quantity-controls input {
    width: 60px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 4px;
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
        <form class="search-form">
            <input type="text" placeholder="Buscar productos..." class="search-input">
            <button type="submit" class="search-button">🔍</button>
        </form>
        <nav class="nav">
            <ul>
                <li><a href="login.php" class="login-btn">Iniciar Sesión</a></li>
                <li><a href="carrito.php"><img src="img/carrito.png" alt="Carrito" class="cart-icon"></a></li>
            </ul>
        </nav>
    </div>
</header>

<!-- Menú debajo del header -->
<div class="sub-menu">
    <div class="menu">
        <ul>
            <li><a href="#" class="menu-button">Compras Recientes</a></li>
            <li><a href="#" class="menu-button">Horario de Atención</a></li>
            <li><a href="#" class="menu-button">Contáctanos</a></li>
        </ul>
    </div>
</div>

<!-- Sección del carrito -->
<div class="section">
    <h2 class="section-title">Tu Carrito</h2>
    <div class="container">
    <form method="post" action="confirm_order.php">
    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <?php
                // Función para crear un ID válido a partir del nombre del producto
                function createValidId($str) {
                    return preg_replace('/[^a-zA-Z0-9_]/', '_', $str);
                }
                
                // URL base para la imagen
                $image_path = 'http://localhost/Zarms/admin/';
                // Construir la URL completa de la imagen
                $image_url = $image_path . htmlspecialchars($row['imagen']);
                
                // Crear un ID válido para el producto
                $valid_id = createValidId($row['nombre_producto']);
                ?>
                <div class="col-md-4 col-xs-12">
                    <div class="product-card">
                        <img src="<?php echo $image_url; ?>" alt="<?php echo htmlspecialchars($row['nombre_producto']); ?>">
                        <h3><?php echo htmlspecialchars($row['nombre_producto']); ?></h3>
                        <p>Precio: $<?php echo htmlspecialchars($row['precio']); ?></p>
                        <div class="quantity-controls">
                            <button type="button" onclick="changeQuantity('<?php echo $valid_id; ?>', -1)">-</button>
                            <input type="text" id="quantity_<?php echo $valid_id; ?>" name="quantity_<?php echo $valid_id; ?>" value="<?php echo htmlspecialchars($row['cantidad']); ?>" data-price="<?php echo htmlspecialchars($row['precio']); ?>">
                            <button type="button" onclick="changeQuantity('<?php echo $valid_id; ?>', 1)">+</button>
                        </div>
                        <p>Total: $<span id="total_<?php echo $valid_id; ?>"><?php echo htmlspecialchars($row['precio'] * $row['cantidad']); ?></span></p>
<input type="hidden" name="hidden_total_<?php echo $valid_id; ?>" id="hidden_total_<?php echo $valid_id; ?>" value="<?php echo htmlspecialchars($row['precio'] * $row['cantidad']); ?>">
 <input type="hidden" name="nombre_producto[]" value="<?php echo htmlspecialchars(trim($row['nombre_producto'])); ?>">
                        <a href="#" class="cta-btn" onclick="confirmRemove('<?php echo htmlspecialchars($row['nombre_producto']); ?>')">Eliminar <i class="fa fa-trash"></i></a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No hay productos en el carrito.</p>
        <?php endif; ?>
    </div>
    <div class="text-center">
        <button type="submit" name="confirmar" class="cta-btn">Confirmar Pedido</button>
    </div>
</form>

<script>
function changeQuantity(productId, change) {
    const quantityInput = document.querySelector(`#quantity_${productId}`);
    let quantity = parseInt(quantityInput.value);
    quantity += change;
    if (quantity < 1) quantity = 1; // Asegura que la cantidad mínima sea 1
    quantityInput.value = quantity;

    const price = parseFloat(quantityInput.getAttribute('data-price'));
    const total = price * quantity;

    console.log(`Cantidad: ${quantity}, Precio: ${price}, Total: ${total.toFixed(2)}`);

    // Actualiza el total visible y el campo oculto
    document.querySelector(`#total_${productId}`).textContent = total.toFixed(2);
    document.querySelector(`#hidden_total_${productId}`).value = total.toFixed(2); // Asegúrate de que este campo se actualiza
}

    function confirmRemove(productName) {
        if (confirm(`¿Estás seguro de que quieres eliminar ${productName} del carrito?`)) {
            // Redirecciona para eliminar el producto (añadir implementación en el archivo PHP)
            window.location.href = `remove_from_cart.php?nombre_producto=${encodeURIComponent(productName)}`;
        }
    }
</script>      
</body>
</html>
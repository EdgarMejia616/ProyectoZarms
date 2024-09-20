<?php
// Incluye el archivo de conexión a la base de datos
include 'db_connection.php'; // Asegúrate de que el archivo de conexión se llame 'db_connection.php'

// Verifica si el parámetro del producto está en la URL
if (isset($_GET['nombre_producto'])) {
    $nombre_producto = $conn->real_escape_string($_GET['nombre_producto']);

    // Elimina el producto del carrito
    $sql_delete = "DELETE FROM carrito WHERE nombre_producto = '$nombre_producto'";
    if ($conn->query($sql_delete) === TRUE) {
        // Verifica si la tabla carrito está vacía
        $sql_check = "SELECT COUNT(*) AS count FROM carrito";
        $result_check = $conn->query($sql_check);
        $row_check = $result_check->fetch_assoc();

        if ($row_check['count'] == 0) {
            // Redirige a index_cliente.php si el carrito está vacío
            header("Location: index_cliente.php");
            exit();
        } else {
            // Redirige a carrito.php si el carrito aún tiene productos
            header("Location: carrito.php");
            exit();
        }
    } else {
        echo "Error al eliminar el producto: " . $conn->error;
    }
} else {
    echo "No se recibió el nombre del producto.";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

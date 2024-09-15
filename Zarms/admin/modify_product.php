<?php
// Conexión a la base de datos
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar y obtener los datos enviados desde el formulario
    $productId = isset($_POST['product-id']) ? intval($_POST['product-id']) : 0;
    $newPrice = isset($_POST['new-price']) ? floatval($_POST['new-price']) : 0;
    $newQuantity = isset($_POST['new-quantity']) ? intval($_POST['new-quantity']) : 0;

    // Verificar que el ID del producto, precio y cantidad sean válidos
    if ($productId > 0 && $newPrice >= 0 && $newQuantity >= 0) {
        // Consulta para actualizar el precio y la cantidad en la base de datos
        $sql = "UPDATE producto SET precio = ?, cantidad = ? WHERE id_producto = ?";

        // Preparar la consulta
        if ($stmt = $conn->prepare($sql)) {
            // Vincular los parámetros
            $stmt->bind_param("dii", $newPrice, $newQuantity, $productId);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Redirigir a la página de productos con un mensaje de éxito
                header("Location: view_products.php?success=Producto modificado exitosamente");
            } else {
                // Redirigir con un mensaje de error si falla la actualización
                header("Location: view_products.php?error=Error al modificar el producto");
            }

            // Cerrar la declaración
            $stmt->close();
        } else {
            // Redirigir con un mensaje de error si falla la preparación de la consulta
            header("Location: view_products.php?error=Error en la consulta SQL");
        }
    } else {
        // Redirigir si los datos proporcionados no son válidos
        header("Location: view_products.php?error=Datos no válidos");
    }
} else {
    // Redirigir si se accede al archivo directamente sin usar el formulario POST
    header("Location: view_products.php");
}

// Cerrar la conexión
$conn->close();
?>

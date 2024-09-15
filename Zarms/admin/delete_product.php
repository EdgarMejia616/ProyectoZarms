<?php
// Conexión a la base de datos
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener el ID del producto a eliminar
    $productId = isset($_POST['product-id']) ? intval($_POST['product-id']) : 0;

    // Verificar que el ID del producto sea válido
    if ($productId > 0) {
        // Consulta para eliminar el producto de la base de datos
        $sql = "DELETE FROM producto WHERE id_producto = ?";

        // Preparar la consulta
        if ($stmt = $conn->prepare($sql)) {
            // Vincular los parámetros
            $stmt->bind_param("i", $productId);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Redirigir a la página de productos con un mensaje de éxito
                header("Location: view_products.php?success=Producto eliminado exitosamente");
            } else {
                // Redirigir con un mensaje de error si falla la eliminación
                header("Location: view_products.php?error=Error al eliminar el producto");
            }

            // Cerrar la declaración
            $stmt->close();
        } else {
            // Redirigir con un mensaje de error si falla la preparación de la consulta
            header("Location: view_products.php?error=Error en la consulta SQL");
        }
    } else {
        // Redirigir si el ID proporcionado no es válido
        header("Location: view_products.php?error=ID de producto no válido");
    }
} else {
    // Redirigir si se accede al archivo directamente sin usar el formulario POST
    header("Location: view_products.php");
}

// Cerrar la conexión
$conn->close();
?>

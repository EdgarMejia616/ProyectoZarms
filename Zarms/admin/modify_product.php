<?php
// Conexión a la base de datos
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = isset($_POST['product-id']) ? intval($_POST['product-id']) : 0;
    $newPrice = isset($_POST['new-price']) ? floatval($_POST['new-price']) : 0;
    $newQuantity = isset($_POST['new-quantity']) ? intval($_POST['new-quantity']) : 0;
    $newCategory = isset($_POST['new-category']) ? intval($_POST['new-category']) : 0;
    $newCategoryName = isset($_POST['new-category-name']) ? $_POST['new-category-name'] : '';

    if ($productId > 0 && $newPrice >= 0 && $newQuantity >= 0 && $newCategory > 0 && !empty($newCategoryName)) {
        // Actualizar la tabla producto
        $sqlProduct = "UPDATE producto SET precio = ?, cantidad = ?, categoria_id = ? WHERE id_producto = ?";

        if ($stmtProduct = $conn->prepare($sqlProduct)) {
            $stmtProduct->bind_param("diii", $newPrice, $newQuantity, $newCategory, $productId);

            if ($stmtProduct->execute()) {
                // Actualizar la tabla categoria
                $sqlCategory = "UPDATE producto SET categoria = ? WHERE categoria_id = ?";

                if ($stmtCategory = $conn->prepare($sqlCategory)) {
                    $stmtCategory->bind_param("si", $newCategoryName, $newCategory);

                    if ($stmtCategory->execute()) {
                        header("Location: view_products.php?success=Producto modificado exitosamente");
                    } else {
                        header("Location: view_products.php?error=Error al modificar la categoría");
                    }

                    $stmtCategory->close();
                } else {
                    header("Location: view_products.php?error=Error en la consulta SQL de categoría");
                }
            } else {
                header("Location: view_products.php?error=Error al modificar el producto");
            }

            $stmtProduct->close();
        } else {
            header("Location: view_products.php?error=Error en la consulta SQL del producto");
        }
    } else {
        header("Location: view_products.php?error=Datos no válidos");
    }
} else {
    header("Location: view_products.php");
}

$conn->close();
?>

<?php
// Conexión a la base de datos
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener el ID del inventario a eliminar
    $inventoryId = isset($_POST['inventory-id']) ? intval($_POST['inventory-id']) : 0;

    // Verificar que el ID del inventario sea válido
    if ($inventoryId > 0) {
        // Consulta para eliminar el inventario de la base de datos
        $sql = "DELETE FROM inventario WHERE id_inventario = ?";

        // Preparar la consulta
        if ($stmt = $conn->prepare($sql)) {
            // Vincular los parámetros
            $stmt->bind_param("i", $inventoryId);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Redirigir a la página de inventario con un mensaje de éxito
                header("Location: view_inventory.php?success=Inventario eliminado exitosamente");
            } else {
                // Redirigir con un mensaje de error si falla la eliminación
                header("Location: view_inventory.php?error=Error al eliminar el inventario");
            }

            // Cerrar la declaración
            $stmt->close();
        } else {
            // Redirigir con un mensaje de error si falla la preparación de la consulta
            header("Location: view_inventory.php?error=Error en la consulta SQL");
        }
    } else {
        // Redirigir si el ID proporcionado no es válido
        header("Location: view_inventory.php?error=ID de inventario no válido");
    }
} else {
    // Redirigir si se accede al archivo directamente sin usar el formulario POST
    header("Location: view_inventory.php");
}

// Cerrar la conexión
$conn->close();
?>

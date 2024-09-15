<?php
// Conexión a la base de datos
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar y obtener los datos enviados desde el formulario
    $inventoryId = isset($_POST['inventory-id']) ? intval($_POST['inventory-id']) : 0;
    $newEntradas = isset($_POST['new-entradas']) ? intval($_POST['new-entradas']) : 0;
    $newSalidas = isset($_POST['new-salidas']) ? intval($_POST['new-salidas']) : 0;

    // Verificar que el ID del inventario, entradas y salidas sean válidos
    if ($inventoryId > 0 && $newEntradas >= 0 && $newSalidas >= 0) {
        // Consulta para actualizar las entradas y salidas en la base de datos
        $sql = "UPDATE inventario SET entradas = ?, salidas = ? WHERE id_inventario = ?";

        // Preparar la consulta
        if ($stmt = $conn->prepare($sql)) {
            // Vincular los parámetros
            $stmt->bind_param("iii", $newEntradas, $newSalidas, $inventoryId);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Redirigir a la página de inventarios con un mensaje de éxito
                header("Location: view_inventory.php?success=Inventario modificado exitosamente");
            } else {
                // Redirigir con un mensaje de error si falla la actualización
                header("Location: view_inventory.php?error=Error al modificar el inventario");
            }

            // Cerrar la declaración
            $stmt->close();
        } else {
            // Redirigir con un mensaje de error si falla la preparación de la consulta
            header("Location: view_inventory.php?error=Error en la consulta SQL");
        }
    } else {
        // Redirigir si los datos proporcionados no son válidos
        header("Location: view_inventory.php?error=Datos no válidos");
    }
} else {
    // Redirigir si se accede al archivo directamente sin usar el formulario POST
    header("Location: view_inventory.php");
}

// Cerrar la conexión
$conn->close();
?>

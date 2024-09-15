<?php
include 'db_connection.php';

if (isset($_POST['id_proveedor'])) {
    $id_proveedor = $_POST['id_proveedor'];

    // Consulta para obtener productos del proveedor
    $query = "SELECT id_producto, nombre_producto, precio FROM producto WHERE id_proveedor = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_proveedor);
    $stmt->execute();
    $result = $stmt->get_result();

    $productos = array();
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }

    // Retornar los datos en formato JSON
    echo json_encode($productos);
}

$conn->close();
?>

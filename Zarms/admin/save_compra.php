<?php
include 'db_connection.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_proveedor = $_POST['id_proveedor'];
    $id_producto = $_POST['id_producto'];
    $nombre_producto = $_POST['nombre_producto'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $total = $_POST['total'];
    $fecha = $_POST['fecha'];

    // Inserción de la compra
    $query = "INSERT INTO compra (id_proveedor, id_producto, nombre_producto, cantidad, fecha, total) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iisisd", $id_proveedor, $id_producto, $nombre_producto, $cantidad, $fecha, $total);

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Compra registrada exitosamente.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error al registrar la compra: ' . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

// Devolver el JSON
header('Content-Type: application/json');
echo json_encode($response);
?>

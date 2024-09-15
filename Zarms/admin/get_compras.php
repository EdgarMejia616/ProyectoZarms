<?php
include 'db_connection.php';

// Establecer el tipo de contenido a JSON
header('Content-Type: application/json');

// Obtener el id_proveedor de la solicitud POST
$id_proveedor = isset($_POST['id_proveedor']) ? $_POST['id_proveedor'] : '';

// Construir la consulta SQL
$sql = "SELECT c.id_compra, p.nombre AS nombre_proveedor, pr.nombre_producto, c.cantidad, c.fecha, (c.cantidad * pr.precio) AS total
        FROM compra c
        INNER JOIN proveedor p ON c.id_proveedor = p.id_proveedor
        INNER JOIN producto pr ON c.id_producto = pr.id_producto";

// Filtrar por id_proveedor si se ha proporcionado
if ($id_proveedor !== '') {
    $sql .= " WHERE c.id_proveedor = ?";
}

// Ordenar por id_compra de menor a mayor
$sql .= " ORDER BY c.id_compra ASC";

// Preparar y ejecutar la consulta
$stmt = $conn->prepare($sql);

if ($id_proveedor !== '') {
    $stmt->bind_param('i', $id_proveedor);
}

$stmt->execute();
$result = $stmt->get_result();

// Recuperar los datos y almacenarlos en un array
$compras = array();
while ($row = $result->fetch_assoc()) {
    $compras[] = $row;
}

// Devolver los datos en formato JSON
echo json_encode($compras);

// Cerrar la conexión
$stmt->close();
$conn->close();
?>

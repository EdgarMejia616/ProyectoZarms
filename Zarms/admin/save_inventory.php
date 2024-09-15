<?php
$servername = "b9adcso2ssjiqbhrwytf-mysql.services.clever-cloud.com";
$username = "uzd4kdukd76ffseo";
$password = "lXa5hn5RkrINOzg9yDaN";
$dbname = "b9adcso2ssjiqbhrwytf";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Comprobar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger datos del formulario
    $id_producto = $_POST['id_producto'] ?? 0;
    $entradas = $_POST['entradas'] ?? 0;
    $salidas = $_POST['salidas'] ?? 0;
    $fecha = $_POST['fecha'] ?? '';

    // Insertar datos en la base de datos
    $sql = "INSERT INTO inventario (id_producto, entradas, salidas, fecha) VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("iiis", $id_producto, $entradas, $salidas, $fecha);

    if ($stmt->execute()) {
        echo "Inventario registrado exitosamente.<br>";
    } else {
        echo "Error al registrar el inventario: " . $stmt->error . "<br>";
    }

    $stmt->close();
}

$conn->close();
?>

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
    $marca = $_POST['marca'] ?? '';

    if (!empty($marca)) {
        // Insertar datos en la tabla marca
        $sql = "INSERT INTO marca (marca) VALUES (?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }

        $stmt->bind_param("s", $marca);

        if ($stmt->execute()) {
            $mensaje = "Éxito";
        } else {
            $mensaje = "Error al registrar la marca: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $mensaje = "El nombre de la marca no puede estar vacío.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Marca</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Estilos del botón de regresar */
        .return-button {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px;
            cursor: pointer;
            font-size: 16px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 10;
            text-decoration: none;
        }

        .return-button i {
            margin-right: 5px;
        }

        .return-button:hover {
            background-color: #0056b3;
        }

        /* Ajuste del body para centrar el contenido */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f7f7f7;
        }

        .register-container {
            padding: 20px;
            max-width: 400px;
            margin: auto;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
            position: relative; /* Añadido para posicionar la notificación */
        }

        .input-box {
            margin-bottom: 15px;
        }

        .input-box label {
            display: block;
            margin-bottom: 5px;
        }

        .input-box input {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .button-container button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .button-container button i {
            margin-right: 5px;
        }

        .button-container button:hover {
            background-color: #0056b3;
        }

        /* Estilos para la notificación emergente */
        .notification {
            display: none;
            position: absolute;
            top: 20px;
            right: -320px; /* Ajustado para estar al lado derecho del formulario */
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 300px;
            z-index: 1000;
            position: absolute;
        }

        .notification .close-btn {
            background-color: transparent;
            border: none;
            color: white;
            font-size: 18px;
            font-weight: bold;
            position: absolute;
            top: 5px;
            right: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<a href="dashboard.php" class="return-button">
    <i class="fa fa-arrow-left"></i> Regresar
</a>

<div class="register-container">
    <h1>Registrar Marca</h1>

    <form id="brand-form" method="POST">
        <div class="input-box">
            <label for="marca">Nombre de la Marca:</label>
            <input type="text" id="marca" name="marca" required>
        </div>

        <div class="button-container">
            <button type="submit"><i class="fa fa-check"></i> Registrar Marca</button>
        </div>
    </form>

    <?php if (isset($mensaje)): ?>
        <div id="notification" class="notification" style="display: block;">
            <?php echo htmlspecialchars($mensaje); ?>
            <button class="close-btn" onclick="closeNotification()">x</button>
        </div>
    <?php endif; ?>
</div>

<script>
    function closeNotification() {
        var notification = document.getElementById('notification');
        notification.style.display = 'none';
    }
</script>

</body>
</html>

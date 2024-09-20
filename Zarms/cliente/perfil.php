<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
    header('Location: login.php');
    exit();
}

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

// Obtener datos del usuario
$userId = $_SESSION['user_id']; 
$userQuery = "SELECT usuario, contraseña, correo FROM usuario WHERE id = ?";
$stmt = $conn->prepare($userQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$userResult = $stmt->get_result();
$userData = $userResult->fetch_assoc();

// Obtener datos del cliente usando el correo
$email = $userData['correo'];
$clientQuery = "SELECT nombre, telefono, direccion FROM cliente WHERE correo = ?";
$stmt = $conn->prepare($clientQuery);
$stmt->bind_param("s", $email);
$stmt->execute();
$clientResult = $stmt->get_result();
$clientData = $clientResult->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="css/promocion.css" />
    <link rel="stylesheet" href="css/prueba.css" />
    <link rel="stylesheet" href="css/styleindex_cliente.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Estilos para el header */
        .header {
            position: fixed;
            z-index: 10;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            padding: 15px 20px;
            font-family: 'Baloo Tamma 2', cursive;
            background: #6EC1E4;
            top: 0;
            left: 0;
        }

        body {
            background-color: #f5f5f5;
            margin-top: 80px; /* Espacio superior para evitar que el contenido se tape */
            font-family: Arial, sans-serif;
        }

        .section {
            padding: 20px;
            text-align: center;
        }

        .profile-info {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            text-align: left;
            margin: 0 auto;
            max-width: 600px; /* Ancho máximo */
        }

        .profile-info p {
            margin: 10px 0;
        }

        .footer {
            margin-top: 40px;
            padding: 20px;
            background-color: #6EC1E4;
            color: white;
            text-align: center;
        }

        .nav ul {
            display: flex;
            justify-content: flex-end;
            margin-right: 20px;
        }

        .nav ul li {
            margin-left: 15px;
        }

        .nav li:hover {
            color: yellow;
            cursor: pointer;
        }

        .btn-modificar {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .btn-modificar:hover {
            background-color: #45a049;
        }
    </style>
    <script src="script_cliente2.js" defer></script>
</head>
<body>

<header class="header">
    <div class="container">
        <div class="logo__container">
            <div class="logogg">
                <img src="img/logo.png" alt="Logo" class="logo-img">
            </div>
        </div>
        <nav class="nav">
            <ul>
                <li>
                    <a href="logout.php" id="cerrar-sesion" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>

<div class="section" style="padding: 20px; text-align: center;">
    <h1>Perfil de Usuario</h1>
    <div class="profile-info">
        <p><strong>Usuario:</strong> <?php echo htmlspecialchars($userData['usuario']); ?></p>
        <p>
            <strong>Contraseña:</strong> 
            <span id="contraseña" data-password="<?php echo htmlspecialchars($userData['contraseña']); ?>">********</span>
            <button id="togglePassword">Mostrar</button>
        </p>
        <p><strong>Correo:</strong> <?php echo htmlspecialchars($userData['correo']); ?></p>
        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($clientData['nombre']); ?></p>
        <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($clientData['telefono']); ?></p>
        <p><strong>Dirección:</strong> <?php echo htmlspecialchars($clientData['direccion']); ?></p>
        
    </div>
</div>

<div id="bottom-footer" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <ul class="footer-payments">
                    <!-- Opciones de pago -->
                </ul>
                <span class="copyright">© 2024 Your Company. All Rights Reserved.</span>
            </div>
        </div>
    </div>
</div>

</body>
</html>
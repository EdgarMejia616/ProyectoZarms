<?php
session_start();
include 'db_connection.php'; // Incluir la conexión a la base de datos

// Función para generar el token Bearer
function generateToken() {
    return bin2hex(random_bytes(16)); // Genera un token aleatorio
}

// Verificar si ya está logueado
if (isset($_SESSION['token']) && isset($_SESSION['authenticated']) && $_SESSION['authenticated']) {
    header('Location: index_cliente.php');
    exit();
}

// Proceso de inicio de sesión
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    // Consulta a la base de datos para verificar usuario y contraseña
    $stmt = $conn->prepare("SELECT id, contraseña FROM usuario WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userId, $hashedPassword);
        $stmt->fetch();

        // Verificar si la contraseña es correcta
        if (password_verify($contraseña, $hashedPassword)) {
            // Generar y almacenar el token
            $token = generateToken();

            // Actualizar el token en la base de datos
            $updateStmt = $conn->prepare("UPDATE usuario SET token = ? WHERE id = ?");
            $updateStmt->bind_param("si", $token, $userId);
            $updateStmt->execute();

            // Establecer variables de sesión
            $_SESSION['token'] = $token;
            $_SESSION['authenticated'] = true;
            $_SESSION['user_id'] = $userId;

            // Redirigir a la pantalla de dashboard
            header('Location: index_cliente.php');
            exit();
        } else {
            $error = 'Contraseña incorrecta.';
        }
    } else {
        $error = 'Usuario no encontrado.';
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
        }

        .login-box {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .input-box {
            margin-bottom: 15px;
            position: relative;
        }

        .input-box input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .input-box button {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #007bff;
            cursor: pointer;
            font-size: 14px;
        }

        .input-box button:hover {
            text-decoration: underline;
        }

        .login-box button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .login-box button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: #dc3545;
            margin-bottom: 15px;
        }

        .register-link {
            margin-top: 10px;
        }

        .register-link a {
            color: #007bff;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Iniciar sesión</h2>
            <?php if ($error): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="POST" action="login.php">
                <div class="input-box">
                    <input type="text" id="usuario" name="usuario" required placeholder="Usuario">
                </div>
                <div class="input-box">
                    <input type="password" id="contraseña" name="contraseña" required placeholder="Contraseña">
                    <button type="button" id="togglePassword">Mostrar</button>
                </div>
                <button type="submit">Iniciar Sesión</button>
            </form>
            <div class="register-link">
                <p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
            </div>
        </div>
    </div>

    <!-- Enlaza el script.js -->
    <script src="script_cliente.js"></script>
</body>
</html>

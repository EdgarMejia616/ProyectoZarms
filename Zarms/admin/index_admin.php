<?php
session_start();
include 'db_connection.php'; // Incluir la conexión a la base de datos

// Función para generar el token Bearer
function generateToken() {
    return bin2hex(random_bytes(16)); // Genera un token aleatorio
}

// Verificar si ya está logueado
if (isset($_SESSION['token']) && isset($_SESSION['authenticated']) && $_SESSION['authenticated']) {
    header('Location: dashboard.php');
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
            header('Location: dashboard.php');
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
    <title>Login Admin</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Iniciar sesión</h2>
            <?php if ($error): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="POST" action="index_admin.php">
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
    <script src="script.js"></script>
</body>
</html>


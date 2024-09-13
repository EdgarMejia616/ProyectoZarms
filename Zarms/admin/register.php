<?php
require 'db_connection.php'; // Archivo donde tienes la conexión a tu base de datos

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Cifra la contraseña
    $correo = $_POST['correo'];

    // Verifica que el nombre de usuario y el correo no estén ya registrados
    $query = "SELECT * FROM usuario WHERE usuario = ? OR correo = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $username, $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "El usuario o correo ya está registrado.";
    } else {
        // Inserta el nuevo usuario en la base de datos
        $query = "INSERT INTO usuario (usuario, contraseña, correo) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $username, $password, $correo);

        if ($stmt->execute()) {
            $success = "Usuario registrado exitosamente. ¡Inicia sesión!";
        } else {
            $error = "Error al registrar el usuario.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Registrar Usuario</h2>
            <?php if ($error): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <?php if ($success): ?>
                <p class="success"><?php echo $success; ?></p>
            <?php endif; ?>
            <form method="POST" action="register.php">
                <div class="input-box">
                    <input type="text" id="username" name="username" required>
                    <label for="username">Usuario</label>
                </div>
                <div class="input-box">
                    <input type="password" id="password" name="password" required>
                    <label for="password">Contraseña</label>
                </div>
                <div class="input-box">
                    <input type="email" id="correo" name="correo" required>
                    <label for="correo">Correo</label>
                </div>
                <button type="submit">Registrar</button>
            </form>
        </div>
    </div>
</body>
</html>

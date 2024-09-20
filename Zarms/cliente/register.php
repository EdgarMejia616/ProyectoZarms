<?php
require 'db_connection.php'; // Archivo de conexión a la base de datos

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Cifrar la contraseña
    $correo = $_POST['correo'];

    // Verificar si el nombre de usuario y el correo ya están registrados en la tabla usuario
    $query = "SELECT * FROM usuario WHERE usuario = ? OR correo = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $username, $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "El usuario o correo ya está registrado.";
    } else {
        // Inserta el nuevo usuario en la tabla usuario
        $query = "INSERT INTO usuario (usuario, contraseña, correo) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $username, $password, $correo);

        if ($stmt->execute()) {
            // Inserta los datos en la tabla cliente
            $queryCliente = "INSERT INTO cliente (nombre, telefono, direccion, correo) VALUES (?, ?, ?, ?)";
            $stmtCliente = $conn->prepare($queryCliente);
            $stmtCliente->bind_param('ssss', $nombre, $telefono, $direccion, $correo);

            if ($stmtCliente->execute()) {
                $success = "Usuario y cliente registrados exitosamente. ¡Inicia sesión!";
            } else {
                $error = "Error al registrar los datos del cliente.";
            }
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
            width: 100%;
        }

        .input-box input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .input-box label {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #999;
            pointer-events: none;
            transition: 0.3s ease;
        }

        .input-box input:focus + label,
        .input-box input:not(:placeholder-shown) + label {
            top: -10px;
            left: 5px;
            font-size: 12px;
            color: #007bff;
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

        .success {
            color: #28a745;
            margin-bottom: 15px;
        }

        /* Estilos para el modal */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
            padding-top: 60px; 
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
            max-width: 300px; 
            text-align: center;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Registrar Usuario</h2>
            <?php if ($error): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <?php if ($success): ?>
                <p class="success" id="success-message"><?php echo $success; ?></p>
                <!-- Modal -->
                <div id="successModal" class="modal">
                    <div class="modal-content">
                        <span class="close" id="closeModal">&times;</span>
                        <p><?php echo $success; ?></p>
                    </div>
                </div>
            <?php endif; ?>
            <form method="POST" action="register.php">
    <div class="input-box">
        <input type="text" id="nombre" name="nombre" required placeholder=" ">
        <label for="nombre">Nombre Completo</label>
    </div>
    <div class="input-box">
        <input type="text" id="telefono" name="telefono" required placeholder=" ">
        <label for="telefono">Teléfono</label>
    </div>
    <div class="input-box">
        <input type="text" id="direccion" name="direccion" required placeholder=" ">
        <label for="direccion">Dirección</label>
    </div>
    <div class="input-box">
        <input type="text" id="username" name="username" required placeholder=" ">
        <label for="username">Usuario</label>
    </div>
    <div class="input-box">
        <input type="password" id="password" name="password" required placeholder=" ">
        <label for="password">Contraseña</label>
    </div>
    <div class="input-box">
        <input type="email" id="correo" name="correo" required placeholder=" ">
        <label for="correo">Correo</label>
    </div>
    <button type="submit">Registrar</button>
</form>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            var successMessage = document.getElementById('success-message').textContent;
            if (successMessage) {
                var modal = document.getElementById('successModal');
                var span = document.getElementById('closeModal');

                modal.style.display = 'block';

                span.onclick = function() {
                    modal.style.display = 'none';
                    window.location.href = 'login.php'; // Redirige al cerrar el modal
                }

                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = 'none';
                        window.location.href = 'login.php'; // Redirige al cerrar el modal
                    }
                }
            }
        });
    </script>
</body>
</html>

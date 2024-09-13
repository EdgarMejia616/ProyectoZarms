<?php
session_start();

// Verificar si hay un token válido
if (!isset($_SESSION['token']) || !isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
    // Si no está autenticado, redirigir al login
    header('Location: index_admin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .dashboard-container {
            display: flex;
            flex-direction: column;
            flex: 1;
            background-color: white;
            padding: 20px;
            margin: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-top: 0;
            color: #333;
            text-align: center;
        }

        .nav-bar {
            background-color: #007bff;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            justify-content: center; /* Centra los elementos en la barra de navegación */
            gap: 10px;
        }

        .nav-bar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 10px;
        }

        .nav-bar li {
            margin: 0;
        }

        .nav-bar a {
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            display: block; /* Hace que el enlace abarque todo el espacio del li */
            transition: background-color 0.3s ease;
            text-align: center; /* Centra el texto dentro del enlace */
        }

        .nav-bar a:hover {
            background-color: #0056b3;
        }

        .nav-bar form {
            flex: 1; /* Hace que el formulario ocupe el espacio restante */
            display: flex;
            justify-content: center; /* Centra el botón dentro del formulario */
        }

        .nav-bar button {
            padding: 10px 20px;
            background-color: #007bff; /* Color azul para el botón de cerrar sesión */
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%; /* Hace que el botón abarque todo el ancho del formulario */
        }

        .nav-bar button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Bienvenido al panel de administración</h1>
        <nav class="nav-bar">
            <ul>
                <li><a href="register_product.php">Registrar Producto</a></li>
                <li><a href="view_orders.php">Ver Pedidos</a></li>
                <li><a href="view_inventory.php">Ver Inventario</a></li>
            </ul>
            <form method="POST" action="logout.php" style="margin: 0;">
                <button type="submit">Cerrar Sesión</button>
            </form>
        </nav>
        <!-- Contenido del panel de administración aquí -->
    </div>
</body>
</html>

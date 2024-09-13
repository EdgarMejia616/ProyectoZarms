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
    <link rel="stylesheet" href="css/style.css">
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
        </nav>
        <form method="POST" action="logout.php">
            <button type="submit">Cerrar Sesión</button>
        </form>
    </div>
</body>
</html>

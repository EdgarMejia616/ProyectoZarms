<?php
session_start(); // Inicia la sesión
include 'db_connection.php'; // Incluye la conexión a la base de datos

function createValidId($str) {
    return preg_replace('/[^a-zA-Z0-9_]/', '_', $str);
}

// Procesar la confirmación del pedido
if (isset($_POST['confirmar'])) {
    if (isset($_POST['nombre_producto']) && is_array($_POST['nombre_producto'])) {
        $nombre_productos = $_POST['nombre_producto'];
        $id_cliente = $_SESSION['user_id'];

        foreach ($nombre_productos as $nombre_producto) {
            $nombre_producto = trim($nombre_producto); // Limpiar espacios
            
            // Asegúrate de que el campo de cantidad se esté capturando correctamente
            $cantidad = isset($_POST['quantity_' . createValidId($nombre_producto)]) ? intval($_POST['quantity_' . createValidId($nombre_producto)]) : 1;
        
            // Obtener el precio del producto
            $sql_get_price = "SELECT precio FROM carrito WHERE nombre_producto = '$nombre_producto'";
            $result_get_price = $conn->query($sql_get_price);
            
            if ($result_get_price && $result_get_price->num_rows > 0) {
                $row_price = $result_get_price->fetch_assoc();
                $precio = $row_price['precio'];
        
                // Calcular el total
                $total = $precio * $cantidad; // Asegúrate de usar este total
    
                // Buscar el id_producto por nombre_producto
                $sql_get_id = "SELECT id_producto FROM producto WHERE nombre_producto = '$nombre_producto'";
                $result_get_id = $conn->query($sql_get_id);
                
                if ($result_get_id->num_rows > 0) {
                    $row_id = $result_get_id->fetch_assoc();
                    $id_producto = $row_id['id_producto'];

                    // Insertar en la tabla pedido incluyendo el id_cliente
                    $sql_insert_pedido = "INSERT INTO pedido (id_producto, nombre_producto, imagen, precio, cantidad, total, id) 
                                          VALUES ('$id_producto', '$nombre_producto', 
                                                  (SELECT imagen FROM carrito WHERE nombre_producto = '$nombre_producto'), 
                                                  '$precio', '$cantidad', '$total', '$id_cliente')";
                    
                    if ($conn->query($sql_insert_pedido) === FALSE) {
                        echo "Error al insertar en la tabla pedido: " . $conn->error;
                    }

                    // Restar la cantidad del producto en la tabla producto
                    $sql_update_producto = "UPDATE producto SET cantidad = cantidad - '$cantidad' WHERE id_producto = '$id_producto'";
                    if ($conn->query($sql_update_producto) === FALSE) {
                        echo "Error al actualizar la tabla producto: " . $conn->error;
                    }
                }

                // Eliminar del carrito
                $sql_delete = "DELETE FROM carrito WHERE nombre_producto = '$nombre_producto'";
                if ($conn->query($sql_delete) === FALSE) {
                    echo "Error al eliminar del carrito: " . $conn->error;
                }
            } else {
                echo "Error al obtener el precio del producto: " . $conn->error;
            }
        }

        // Cerrar la conexión a la base de datos
        $conn->close();
        
        // Redirigir con una notificación
        echo '<script>
                alert("Pedido confirmado");
                window.location.href = "checkout.php";
              </script>';
        exit();
    } else {
        echo "No se recibieron productos.";
    }
} else {
    echo "No se pudo confirmar el pedido.";
}
?>
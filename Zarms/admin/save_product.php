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
    $nombre_producto = $_POST['nombre_producto'] ?? '';
    $precio = $_POST['precio'] ?? 0.0;
    $categoria_id = $_POST['categoria_id'] ?? 0;
    $categoria_nombre = $_POST['categoria'] ?? '';
    $marca_id = $_POST['marca_id'] ?? 0;
    $marca_nombre = $_POST['marca'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $cantidad = $_POST['cantidad'] ?? 0;
    $estado = $_POST['estado'] ?? '';
    $id_proveedor = $_POST['id_proveedor'] ?? 0;

    // Manejar carga de imagen
    $imagen = '';
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Verificar si el archivo es una imagen
        $check = getimagesize($_FILES["imagen"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "El archivo no es una imagen.<br>";
            $uploadOk = 0;
        }

        // Verificar el tamaño del archivo
        if ($_FILES["imagen"]["size"] > 500000) {
            echo "El archivo es demasiado grande.<br>";
            $uploadOk = 0;
        }

        // Permitir ciertos formatos de imagen
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Solo se permiten archivos JPG, JPEG, PNG y GIF.<br>";
            $uploadOk = 0;
        }

        // Verificar si $uploadOk está en 0 debido a un error
        if ($uploadOk == 0) {
            echo "El archivo no se subió.<br>";
        } else {
            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
                $imagen = $target_file; // Guardar la ruta del archivo
                echo "Imagen subida correctamente.<br>";
            } else {
                echo "Hubo un error al subir el archivo.<br>";
            }
        }
    } else {
        echo "No se ha enviado una imagen o hubo un error en el archivo.<br>";
    }

    // Insertar datos en la base de datos
    $sql = "INSERT INTO producto (nombre_producto, precio, categoria_id, categoria, marca_id, marca, descripcion, cantidad, imagen, estado, id_proveedor)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("ssdissssssi", $nombre_producto, $precio, $categoria_id, $categoria_nombre, $marca_id, $marca_nombre, $descripcion, $cantidad, $imagen, $estado, $id_proveedor);

    if ($stmt->execute()) {
        echo "Producto registrado exitosamente.<br>";
    } else {
        echo "Error al registrar el producto: " . $stmt->error . "<br>";
    }

    $stmt->close();
}

$conn->close();
?>
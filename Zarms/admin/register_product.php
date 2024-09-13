<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Producto</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="register-container">
        <h1>Registrar Producto</h1>
        <form method="POST" action="save_product.php" enctype="multipart/form-data">
            <div class="input-box">
                <label for="nombre_producto">Nombre del Producto:</label>
                <input type="text" id="nombre_producto" name="nombre_producto" required>
            </div>

            <div class="input-box">
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" step="0.01" required>
            </div>

            <div class="input-box">
                <label for="categoria_id">Categoría:</label>
                <select id="categoria_id" name="categoria_id" onchange="updateCategoria(this)" required>
                    <option value="">Selecciona una categoría</option>
                    <?php
                    include 'db_connection.php';

                    // Consultar categorías
                    $result = $conn->query("SELECT categoria_id, categoria FROM categoria");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['categoria_id'] . "' data-nombre='" . $row['categoria'] . "'>" . $row['categoria'] . "</option>";
                    }
                    ?>
                </select>
                <input type="hidden" id="categoria" name="categoria">
            </div>

            <div class="input-box">
                <label for="marca_id">Marca:</label>
                <select id="marca_id" name="marca_id" onchange="updateMarca(this)" required>
                    <option value="">Selecciona una marca</option>
                    <?php
                    // Consultar marcas
                    $result = $conn->query("SELECT marca_id, marca FROM marca");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['marca_id'] . "' data-nombre='" . $row['marca'] . "'>" . $row['marca'] . "</option>";
                    }
                    ?>
                </select>
                <input type="hidden" id="marca" name="marca">
            </div>

            <div class="input-box">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion"></textarea>
            </div>

            <div class="input-box">
                <label for="cantidad">Cantidad:</label>
                <input type="number" id="cantidad" name="cantidad" required>
            </div>

            <div class="input-box">
                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen">
            </div>

            <div class="input-box">
                <label for="estado">Estado:</label>
                <select id="estado" name="estado" required>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
            </div>

            <div class="input-box">
                <label for="id_proveedor">Proveedor:</label>
                <select id="id_proveedor" name="id_proveedor" required>
                    <?php
                    // Consultar proveedores
                    $result = $conn->query("SELECT id_proveedor, nombre_producto FROM proveedor");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id_proveedor'] . "'>" . $row['nombre_producto'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit">Registrar Producto</button>
        </form>
    </div>

    <script>
        function updateCategoria(select) {
            var categoriaNombre = select.options[select.selectedIndex].getAttribute('data-nombre');
            document.getElementById('categoria').value = categoriaNombre;
        }

        function updateMarca(select) {
            var marcaNombre = select.options[select.selectedIndex].getAttribute('data-nombre');
            document.getElementById('marca').value = marcaNombre;
        }
    </script>
</body>
</html>

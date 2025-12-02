<?php
require 'seguridad.php'; // <--- EL CANDADO IMPORTANTE
require 'conexion.php';

// Consulta para llenar la tabla
$consulta = "SELECT * FROM productos ORDER BY nombre ASC";
$resultado = $conexion->query($consulta);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Admin Florería</title>
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>

    <header>
        <h1>Panel de Administración</h1>
        <nav>
            <a href="admin_productos.php" class="active">Administrar Productos</a>
            <a href="admin_pedidos.php">Administrar Pedidos</a>
            <a href="logout.php" style="background-color: #d32f2f; margin-left: 15px;">Cerrar Sesión</a>
        </nav>
    </header>

    <div class="container">

        <h2>Registrar Nuevo Producto (Inventario)</h2>
        
        <form action="guardar_producto.php" method="POST">
            <label for="nombre">Nombre del producto:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4"></textarea>

            <label for="precio">Precio (ej. 350):</label>
            <input type="number" id="precio" name="precio" required>

            <label for="imagen_url">Ruta de la Imagen (ej. img/ramo_rosas.jpg):</label>
            <input type="text" id="imagen_url" name="imagen_url">

            <button type="submit">Guardar Producto</button>
        </form>

        <hr style="margin-top: 30px;">
        
        <h2>Productos Actuales (Inventario)</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Imagen</th> 
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultado->num_rows > 0) {
                    while($fila = $resultado->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo $fila['id_producto']; ?></td>
                            <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($fila['descripcion']); ?></td>
                            <td>$<?php echo $fila['precio']; ?></td>
                            
                            <td>
                                <img src="../<?php echo htmlspecialchars($fila['imagen_url']); ?>" 
                                     alt="<?php echo htmlspecialchars($fila['nombre']); ?>" 
                                     class="product-image">
                            </td>
                            
                            <td>
                                <a href="editar_producto.php?id=<?php echo $fila['id_producto']; ?>" class="btn-editar">Modificar</a>
                                <a href="eliminar_producto.php?id=<?php echo $fila['id_producto']; ?>" class="btn-eliminar" onclick="return confirm('¿Estás seguro?');">Eliminar</a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay productos registrados todavía.</td></tr>";
                }
                ?>
            </tbody>
        </table>

    </div>
</body>
</html>
<?php
$conexion->close();
?>
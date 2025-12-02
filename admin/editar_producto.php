<?php
require 'conexion.php';

// 1. Obtener el ID del producto de la URL
$id_producto = $_GET['id'];

// 2. Consultar la base de datos para ESE producto
$stmt = $conexion->prepare("SELECT * FROM productos WHERE id_producto = ?");
$stmt->bind_param("i", $id_producto);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $producto = $resultado->fetch_assoc();
} else {
    die("Error: Producto no encontrado.");
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Producto</title>
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>
    
    <header>
        <h1>Panel de Administración</h1>
        <nav>
            <a href="admin_productos.php" class="active">Administrar Productos</a>
            <!--<a href="admin_pedidos.php">Administrar Pedidos</a>-->
            <a href="logout.php" style="background-color: #d32f2f; margin-left: 15px;">Cerrar Sesión</a>
        </nav>
    </header>

    <div class="container"> 

        <h2>Modificar Producto: <?php echo htmlspecialchars($producto['nombre']); ?></h2>

        <form action="actualizar_producto.php" method="POST">
            
            <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">

            <label for="nombre">Nombre del producto:</label><br>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>

            <label for="descripcion">Descripción:</label><br>
            <textarea id="descripcion" name="descripcion" rows="4" cols="50"><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>

            <label for="precio">Precio:</label><br>
            <input type="number" id="precio" name="precio" value="<?php echo $producto['precio']; ?>" required>

            <label for="cantidad">Cantidad en stock:</label><br>
            <input type="number" id="cantidad" name="cantidad" value="<?php echo $producto['cantidad']; ?>" required>

            <label for="imagen_url">Ruta de la Imagen:</label><br>
            <input type="text" id="imagen_url" name="imagen_url" value="<?php echo htmlspecialchars($producto['imagen_url']); ?>">
            <br>
            
            <button type="submit">Actualizar Producto</button>
            <a href="admin_productos.php" class="btn-eliminar" style="margin-left: 10px; padding: 12px 20px; display: inline-block;">Cancelar</a>
        </form>

    </div> </body>
</html>

<?php
// Cerramos la conexión al final del script, si no se cerró antes.
$conexion->close();
?>
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
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Producto</title>
</head>
<body>

    <h2>Modificar Producto: <?php echo htmlspecialchars($producto['nombre']); ?></h2>

    <form action="actualizar_producto.php" method="POST">
        
        <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">

        <label for="nombre">Nombre del producto:</label><br>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
        <br><br>

        <label for="descripcion">Descripción:</label><br>
        <textarea id="descripcion" name="descripcion" rows="4" cols="50"><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
        <br><br>

        <label for="precio">Precio:</label><br>
        <input type="number" id="precio" name="precio" value="<?php echo $producto['precio']; ?>" required>
        <br><br>

        <label for="imagen_url">Ruta de la Imagen:</label><br>
        <input type="text" id="imagen_url" name="imagen_url" value="<?php echo htmlspecialchars($producto['imagen_url']); ?>">
        <br><br>

        <button type="submit">Actualizar Producto</button>
        <a href="admin_productos.php">Cancelar</a>
    </form>

</body>
</html>
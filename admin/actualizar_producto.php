<?php
// 1. Incluir la conexión
require 'conexion.php';

// 2. Verificar que los datos lleguen por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 3. Recibir TODOS los datos (incluido el ID oculto)
    $id_producto = $_POST['id_producto'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $imagen_url = $_POST['imagen_url'];

    // 4. Preparar la consulta SQL de MODIFICACIÓN (Update)
    $stmt = $conexion->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, imagen_url = ? WHERE id_producto = ?");
    
    // "ssisi" = string, string, integer, string, integer
    $stmt->bind_param("ssisi", $nombre, $descripcion, $precio, $imagen_url, $id_producto);

    // 5. Ejecutar y verificar
    if ($stmt->execute()) {
        // Éxito: redirigir al panel de administración
        header("Location: admin_productos.php");
        exit();
    } else {
        echo "Error al actualizar el producto: " . $stmt->error;
    }

    // 6. Cerrar
    $stmt->close();
    $conexion->close();

} else {
    // Si alguien intenta acceder a este archivo directamente
    header("Location: admin_productos.php");
    exit();
}
?>
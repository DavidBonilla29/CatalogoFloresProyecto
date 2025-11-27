<?php
// 1. Incluir la conexión
require 'conexion.php';

// 2. Verificar que se recibió un ID
if (isset($_GET['id'])) {
    
    $id_producto = $_GET['id'];

    // 3. Preparar la consulta SQL de ELIMINAR (Delete)
    $stmt = $conexion->prepare("DELETE FROM productos WHERE id_producto = ?");
    
    // "i" = integer
    $stmt->bind_param("i", $id_producto);

    // 4. Ejecutar y verificar
    if ($stmt->execute()) {
        // Éxito: redirigir al panel de administración
        header("Location: admin_productos.php");
        exit();
    } else {
        echo "Error al eliminar el producto: " . $stmt->error;
    }

    // 5. Cerrar
    $stmt->close();
    $conexion->close();

} else {
    // Si no se proporcionó ID
    header("Location: admin_productos.php");
    exit();
}
?>
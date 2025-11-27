<?php
// 1. Incluir la conexión
require 'conexion.php';

// 2. Verificar que se recibió un ID
if (isset($_GET['id'])) {
    
    $id_pedido = $_GET['id'];

    // 3. Preparar la consulta SQL de ELIMINAR (Delete)
    $stmt = $conexion->prepare("DELETE FROM pedidos WHERE id_pedido = ?");
    
    // "i" = integer
    $stmt->bind_param("i", $id_pedido);

    // 4. Ejecutar y verificar
    if ($stmt->execute()) {
        // Éxito: redirigir al panel de pedidos
        header("Location: admin_pedidos.php");
        exit();
    } else {
        echo "Error al eliminar el pedido: " . $stmt->error;
    }

    // 5. Cerrar
    $stmt->close();
    $conexion->close();

} else {
    // Si no se proporcionó ID
    header("Location: admin_pedidos.php");
    exit();
}
?>
<?php
// 1. Incluir la conexión
require 'conexion.php';

// 2. Verificar que los datos lleguen por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 3. Recibir TODOS los datos (incluido el ID oculto)
    $id_pedido = $_POST['id_pedido'];
    $nombre_cliente = $_POST['nombre_cliente'];
    $telefono_cliente = $_POST['telefono_cliente'];
    $id_producto = $_POST['id_producto'];
    $costo_total = $_POST['costo_total'];
    $fecha_entrega = $_POST['fecha_entrega'];
    $estado = $_POST['estado'];

    // 4. Preparar la consulta SQL de MODIFICACIÓN (Update)
    $stmt = $conexion->prepare("
        UPDATE pedidos 
        SET nombre_cliente = ?, telefono_cliente = ?, id_producto_solicitado = ?, 
            costo_total = ?, fecha_entrega = ?, estado = ?
        WHERE id_pedido = ?
    ");
    
    // "ssiissi" = string, string, integer, integer, string, string, integer
    $stmt->bind_param("ssiissi", 
        $nombre_cliente, 
        $telefono_cliente, 
        $id_producto, 
        $costo_total, 
        $fecha_entrega, 
        $estado, 
        $id_pedido
    );

    // 5. Ejecutar y verificar
    if ($stmt->execute()) {
        // Éxito: redirigir al panel de pedidos
        header("Location: admin_pedidos.php");
        exit();
    } else {
        echo "Error al actualizar el pedido: " . $stmt->error;
    }

    // 6. Cerrar
    $stmt->close();
    $conexion->close();

} else {
    // Si alguien intenta acceder a este archivo directamente
    header("Location: admin_pedidos.php");
    exit();
}
?>
<?php
// 1. Incluir la conexión
require 'conexion.php';

// 2. Verificar que los datos lleguen por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 3. Recibir los datos del formulario
    $nombre_cliente = $_POST['nombre_cliente'];
    $telefono_cliente = $_POST['telefono_cliente'];
    $id_producto = $_POST['id_producto'];
    $costo_total = $_POST['costo_total'];
    $fecha_entrega = $_POST['fecha_entrega'];
    $estado = $_POST['estado'];

    // 4. Preparar la consulta SQL (para evitar inyección SQL)
    $stmt = $conexion->prepare("INSERT INTO pedidos (nombre_cliente, telefono_cliente, id_producto_solicitado, costo_total, fecha_entrega, estado) VALUES (?, ?, ?, ?, ?, ?)");

    // 5. Vincular los datos a los marcadores
    // s = string (nombre)
    // s = string (telefono)
    // i = integer (id_producto)
    // i = integer (costo_total)
    // s = string (fecha_entrega)
    // s = string (estado)
    $stmt->bind_param("ssiiss", $nombre_cliente, $telefono_cliente, $id_producto, $costo_total, $fecha_entrega, $estado);

    // 6. Ejecutar la consulta
    if ($stmt->execute()) {
        // Si fue exitoso, redirigimos de vuelta al panel de pedidos
        header("Location: admin_pedidos.php");
        exit();
    } else {
        // Si hubo un error
        echo "Error al guardar el pedido: " . $stmt->error;
    }

    // 7. Cerrar la sentencia y la conexión
    $stmt->close();
    $conexion->close();

} else {
    // Si alguien intenta acceder a este archivo directamente
    header("Location: admin_pedidos.php");
    exit();
}
?>
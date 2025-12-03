<?php
// procesar_compra.php - VERSIÓN CON DETECCIÓN DE STOCK CERO

// 1. Incluir la conexión (Asegúrate que la ruta sea correcta según tu estructura)
// SI 'conexion.php' está en la carpeta 'admin', usa:
require 'admin/conexion.php';
// SI 'conexion.php' está en la misma carpeta que este archivo, usa:
// require 'conexion.php';

// 2. Verificar que se recibieron los datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productos_comprados = json_decode($_POST['productos_comprados'] ?? '[]', true);

    if (empty($productos_comprados)) {
        http_response_code(400); 
        echo json_encode(['success' => false, 'message' => 'No se recibieron productos.']);
        exit();
    }
    
    // Iniciar la transacción para asegurar atomicidad.
    $conexion->begin_transaction();
    $exito = true;
    $errores_stock = []; // Array para recolectar nombres de productos agotados

    // 3. Preparar la consulta SQL de actualización de stock
    // La cláusula AND cantidad > 0 nos ayuda a detectar si falló por stock cero.
    $stmt = $conexion->prepare("UPDATE productos SET cantidad = cantidad - 1 WHERE id_producto = ? AND cantidad > 0");
    
    if (!$stmt) {
        $conexion->rollback();
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta: ' . $conexion->error]);
        exit();
    }

    foreach ($productos_comprados as $producto) {
        $id_producto = $producto['id'];
        $nombre_producto = $producto['nombre'];

        $stmt->bind_param("i", $id_producto);
        
        if (!$stmt->execute()) {
            $exito = false;
            // Error SQL grave (ej. tabla no existe)
            error_log("Error SQL en procesar_compra: " . $stmt->error);
            $mensaje_alerta = 'Error grave del servidor al procesar la compra.';
            break; 
        }
        
        // Si no se afectó ninguna fila, es porque el stock era 0 o el ID es incorrecto.
        if ($stmt->affected_rows === 0) {
            $exito = false; // Marcamos el fallo de la transacción
            $errores_stock[] = $nombre_producto; // Guardamos el nombre del producto agotado
        }
    }
    
    // 4. Finalizar la transacción
    $stmt->close();

    if ($exito) {
        $conexion->commit(); // Éxito: aplicamos todos los cambios
        echo json_encode(['success' => true, 'message' => 'Stock actualizado exitosamente.']);
    } else {
        $conexion->rollback(); // Error: deshacemos todos los cambios
        
        $mensaje_alerta = 'Error desconocido al procesar el inventario.';

        if (!empty($errores_stock)) {
            // Si hubo productos agotados
            $lista_productos = implode(", ", array_unique($errores_stock));
            $mensaje_alerta = "¡Alerta de Stock! 🥀 No hay suficiente inventario para los siguientes productos: " . $lista_productos . ". Por favor, quítalos del carrito e inténtalo de nuevo.";
        }
        
        http_response_code(409); // 409 Conflict: Conflicto de recursos (Stock).
        echo json_encode([
            'success' => false, 
            'message' => $mensaje_alerta
        ]);
    }

    $conexion->close();

} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>
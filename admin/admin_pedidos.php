<?php
require 'seguridad.php'; // Candado de seguridad
require 'conexion.php';

// --- CONSULTA 1: Para el formulario ---
$consulta_productos = "SELECT id_producto, nombre, precio FROM productos ORDER BY nombre ASC";
$resultado_productos = $conexion->query($consulta_productos);

// --- CONSULTA 2: Para la lista de pedidos ---
$consulta_pedidos = "
    SELECT 
        pedidos.id_pedido, 
        pedidos.nombre_cliente, 
        pedidos.telefono_cliente,
        productos.nombre AS nombre_producto,
        pedidos.costo_total,
        pedidos.fecha_entrega,
        pedidos.estado
    FROM pedidos
    LEFT JOIN productos 
        ON pedidos.id_producto_solicitado = productos.id_producto
    ORDER BY pedidos.id_pedido DESC
";
$resultado_pedidos = $conexion->query($consulta_pedidos);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos - Admin Florería</title>
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>

    <header>
        <h1>Panel de Administración</h1>
        <nav>
            <a href="admin_productos.php">Administrar Productos</a>
            <a href="admin_pedidos.php" class="active">Administrar Pedidos</a>
            <a href="logout.php" style="background-color: #d32f2f; margin-left: 15px;">Cerrar Sesión</a>
        </nav>
    </header>

    <div class="container">

        <h2>Registrar Nuevo Pedido</h2>
        
        <form action="guardar_pedido.php" method="POST">
            <label for="nombre_cliente">Nombre del Cliente:</label>
            <input type="text" id="nombre_cliente" name="nombre_cliente" required>

            <label for="telefono_cliente">Teléfono del Cliente:</label>
            <input type="text" id="telefono_cliente" name="telefono_cliente">

            <label for="id_producto">Producto Solicitado:</label>
            <select id="id_producto" name="id_producto" required>
                <option value="" data-precio="">-- Seleccione un producto --</option>
                <?php
                $resultado_productos->data_seek(0); 
                if ($resultado_productos->num_rows > 0) {
                    while($fila = $resultado_productos->fetch_assoc()) {
                        echo "<option value='" . $fila['id_producto'] . "' data-precio='" . $fila['precio'] . "'>" 
                             . htmlspecialchars($fila['nombre']) 
                             . "</option>";
                    }
                }
                ?>
            </select>

            <label for="costo_total">Costo Total (ej. 350):</label>
            <input type="number" id="costo_total" name="costo_total" required>

            <label for="fecha_entrega">Fecha de Entrega:</label>
            <input type="date" id="fecha_entrega" name="fecha_entrega">
            
            <label for="estado">Estado del Pedido:</label>
            <select id="estado" name="estado">
                <option value="Pendiente" selected>Pendiente</option>
                <option value="En Proceso">En Proceso</option>
                <option value="Entregado">Entregado</option>
                <option value="Cancelado">Cancelado</option>
            </select>

            <button type="submit">Guardar Pedido</button>
        </form>

        <hr style="margin-top: 30px;">

        <h2>Pedidos Registrados</h2>
        
        <table>
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Cliente</th>
                    <th>Teléfono</th>
                    <th>Producto Solicitado</th>
                    <th>Costo Total</th>
                    <th>Fecha Entrega</th>
                    <th>Estado</th>
                    <th>Acciones</th> </tr>
            </thead>
            <tbody>
                <?php
                if ($resultado_pedidos->num_rows > 0) {
                    while($fila_pedido = $resultado_pedidos->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?php echo $fila_pedido['id_pedido']; ?></td>
                        <td><?php echo htmlspecialchars($fila_pedido['nombre_cliente']); ?></td>
                        <td><?php echo htmlspecialchars($fila_pedido['telefono_cliente']); ?></td>
                        <td><?php echo $fila_pedido['nombre_producto'] ? htmlspecialchars($fila_pedido['nombre_producto']) : '<span style="color:red;">N/A</span>'; ?></td> 
                        <td>$<?php echo $fila_pedido['costo_total']; ?></td>
                        <td><?php echo $fila_pedido['fecha_entrega']; ?></td>
                        <td><?php echo htmlspecialchars($fila_pedido['estado']); ?></td>
                        
                        <td>
                            <a href="editar_pedido.php?id=<?php echo $fila_pedido['id_pedido']; ?>" class="btn-editar">Modificar</a>
                            <a href="eliminar_pedido.php?id=<?php echo $fila_pedido['id_pedido']; ?>" class="btn-eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este pedido?');">Eliminar</a>
                        </td>
                    </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='8'>No hay pedidos registrados todavía.</td></tr>";
                }
                ?>
            </tbody>
        </table>

    </div><script>
        document.addEventListener('DOMContentLoaded', function() {
            const productoSelect = document.getElementById('id_producto');
            const costoInput = document.getElementById('costo_total');
            productoSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const precio = selectedOption.getAttribute('data-precio');
                costoInput.value = precio;
            });
        });
    </script>

</body>
</html>
<?php
$conexion->close();
?>
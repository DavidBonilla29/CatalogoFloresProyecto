<?php
require 'conexion.php';

// 1. Obtener el ID del pedido de la URL
$id_pedido = $_GET['id'];

// 2. Consultar la base de datos para ESE pedido
$stmt = $conexion->prepare("SELECT * FROM pedidos WHERE id_pedido = ?");
$stmt->bind_param("i", $id_pedido);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $pedido = $resultado->fetch_assoc();
} else {
    die("Error: Pedido no encontrado.");
}
$stmt->close();

// 3. Consultar TODOS los productos para el menú desplegable
$consulta_productos = "SELECT id_producto, nombre, precio FROM productos ORDER BY nombre ASC";
$resultado_productos = $conexion->query($consulta_productos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Pedido - Admin</title>
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>

    <header>
        <h1>Panel de Administración</h1>
        <nav>
            <a href="admin_productos.php">Administrar Productos</a>
            <a href="admin_pedidos.php">Administrar Pedidos</a>
        </nav>
    </header>

    <div class="container">

        <h2>Modificar Pedido #<?php echo $pedido['id_pedido']; ?></h2>

        <form action="actualizar_pedido.php" method="POST">
            
            <input type="hidden" name="id_pedido" value="<?php echo $pedido['id_pedido']; ?>">

            <label for="nombre_cliente">Nombre del Cliente:</label>
            <input type="text" id="nombre_cliente" name="nombre_cliente" value="<?php echo htmlspecialchars($pedido['nombre_cliente']); ?>" required>

            <label for="telefono_cliente">Teléfono del Cliente:</label>
            <input type="text" id="telefono_cliente" name="telefono_cliente" value="<?php echo htmlspecialchars($pedido['telefono_cliente']); ?>">

            <label for="id_producto">Producto Solicitado:</label>
            <select id="id_producto" name="id_producto" required>
                <option value="" data-precio="">-- Seleccione un producto --</option>
                <?php
                if ($resultado_productos->num_rows > 0) {
                    while($fila_prod = $resultado_productos->fetch_assoc()) {
                        // Marcar el producto que ya estaba seleccionado
                        $selected_prod = ($fila_prod['id_producto'] == $pedido['id_producto_solicitado']) ? 'selected' : '';
                        echo "<option value='" . $fila_prod['id_producto'] . "' data-precio='" . $fila_prod['precio'] . "' " . $selected_prod . ">" 
                             . htmlspecialchars($fila_prod['nombre']) 
                             . "</option>";
                    }
                }
                ?>
            </select>

            <label for="costo_total">Costo Total:</label>
            <input type="number" id="costo_total" name="costo_total" value="<?php echo $pedido['costo_total']; ?>" required>

            <label for="fecha_entrega">Fecha de Entrega:</label>
            <input type="date" id="fecha_entrega" name="fecha_entrega" value="<?php echo $pedido['fecha_entrega']; ?>">
            
            <label for="estado">Estado del Pedido:</label>
            <select id="estado" name="estado">
                <option value="Pendiente" <?php if ($pedido['estado'] == 'Pendiente') echo 'selected'; ?>>Pendiente</option>
                <option value="En Proceso" <?php if ($pedido['estado'] == 'En Proceso') echo 'selected'; ?>>En Proceso</option>
                <option value="Entregado" <?php if ($pedido['estado'] == 'Entregado') echo 'selected'; ?>>Entregado</option>
                <option value="Cancelado" <?php if ($pedido['estado'] == 'Cancelado') echo 'selected'; ?>>Cancelado</option>
            </select>

            <button type="submit">Actualizar Pedido</button>
            <a href="admin_pedidos.php" style="margin-left: 10px;">Cancelar</a>
        </form>

    </div>

    <script>
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
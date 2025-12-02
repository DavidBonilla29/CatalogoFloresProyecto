<?php
// guardar_producto.php

// 1. Incluir la conexión
require 'conexion.php';

// 2. Recibir los datos del formulario (método POST)
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$cantidad= $_POST['cantidad'];
$imagen_url = $_POST['imagen_url'];

// 3. Preparar la consulta SQL
$stmt = $conexion->prepare("INSERT INTO productos (nombre, descripcion, precio,cantidad, imagen_url) VALUES (?, ?, ?, ?, ?)");

// 4. Vincular los datos (s = string, i = integer)
$stmt->bind_param("ssiis", $nombre, $descripcion, $precio,$cantidad, $imagen_url);

// 5. Ejecutar la consulta
if ($stmt->execute()) {
    // Si fue exitoso, redirigimos de vuelta al panel de admin
    header("Location: admin_productos.php");
    exit(); 
} else {
    // Si hubo un error
    echo "Error al guardar el producto: " . $stmt->error;
}

// 6. Cerrar la sentencia y la conexión
$stmt->close();
$conexion->close();
?>
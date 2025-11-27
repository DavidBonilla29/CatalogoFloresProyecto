<?php
// conexion.php

$servidor = "localhost";
$usuario = "root";
$password = ""; // Pon tu contraseña de MariaDB si tienes una
$base_datos = "floreria_db";

// Crear la conexión
$conexion = new mysqli($servidor, $usuario, $password, $base_datos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Asegurar que los datos se manejen en UTF-8
$conexion->set_charset("utf8");
?>
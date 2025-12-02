<?php
session_start();

// Verificamos si la variable de sesión existe y es verdadera
if (!isset($_SESSION['usuario_logueado']) || $_SESSION['usuario_logueado'] !== true) {
    // Si no está logueado, lo mandamos al login
    header("Location: login.php");
    exit();
}
?>
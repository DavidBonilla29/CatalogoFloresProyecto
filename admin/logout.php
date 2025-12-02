<?php
// logout.php
session_start();

// Borrar todas las variables de sesión
session_unset();

// Destruir la sesión completamente
session_destroy();

// Redirigir al login
header("Location: login.php");
exit();
?>
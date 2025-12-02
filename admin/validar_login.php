<?php
// validar_login.php
require 'conexion.php';
session_start();

// Verificar que los datos vienen por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recibimos los datos
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    // Preparamos la consulta para buscar al usuario de forma segura
    $stmt = $conexion->prepare("SELECT id_usuario, usuario, password FROM usuarios_admin WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Si encontramos al usuario...
    if ($resultado->num_rows === 1) {
        $fila = $resultado->fetch_assoc();
        
        // VERIFICAMOS LA CONTRASEÑA (el hash)
        if (password_verify($password, $fila['password'])) {
            
            // ¡Login Exitoso! Guardamos "el pase" en la sesión
            $_SESSION['usuario_logueado'] = true;
            $_SESSION['id_usuario'] = $fila['id_usuario'];
            $_SESSION['nombre_usuario'] = $fila['usuario'];
            
            // Redirigimos al panel principal
            header("Location: admin_productos.php");
            exit();

        } else {
            // Contraseña incorrecta -> Volver con error
            header("Location: login.php?error=1");
            exit();
        }
    } else {
        // Usuario no existe -> Volver con error
        header("Location: login.php?error=1");
        exit();
    }
    
    $stmt->close();
    $conexion->close();

} else {
    // Si intentan entrar directo sin formulario
    header("Location: login.php");
    exit();
}
?>
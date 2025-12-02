<?php
session_start();
if (isset($_SESSION['usuario_logueado']) && $_SESSION['usuario_logueado'] === true) {
    header("Location: admin_productos.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Florería Orlandito</title>
    <link rel="stylesheet" href="admin_styles.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f7f6;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            text-align: center;
        }
        .login-header {
            background-color: #2E7D32; /* Fondo Verde */
            padding: 25px 20px;
            width: 100%;
            box-sizing: border-box;
        }
        /* AQUI ESTA LA CORRECCION CLAVE */
        .login-header h2 {
            margin: 0;
            font-size: 20px; 
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 1px;
            
            /* Forzamos el color blanco y quitamos bordes heredados */
            color: #ffffff !important; 
            border: none !important;
            padding: 0 !important;
        }
        
        .login-body {
            padding: 30px;
        }
        .error-msg {
            color: #d32f2f;
            background-color: #ffcdd2;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 0.9em;
        }
        form label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #333;
            text-align: left;
        }
        form input[type="text"],
        form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        form button {
            background-color: #E91E63;
            color: white;
            font-size: 16px;
            font-weight: bold;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 25px;
            transition: background-color 0.3s;
        }
        form button:hover {
            background-color: #c2185b;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-header">
            <h2>INICIE SESION ADMINISTRADOR</h2>
        </div>

        <div class="login-body">
            <?php 
            if(isset($_GET['error'])) {
                echo '<div class="error-msg">Usuario o contraseña incorrectos.</div>';
            }
            ?>

            <form action="validar_login.php" method="POST">
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" required autofocus>

                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Ingresar</button>
            </form>
        </div>
    </div>

</body>
</html>
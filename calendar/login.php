<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/styles_login.css">
    <link rel="stylesheet" href="css/styles_pantalla_de_carga.css">
</head>
<body>
    <!-- Pantalla de carga -->
    <div class="loader-wrapper" id="loader-wrapper">
        <!-- Mostrar la imagen de carga -->
        <!--<div class="loader"></div>-->
        <img src="imagen/caracol_loading.png" alt="Cargando..."> 
    </div>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <form id="loginForm" action="#" method="post">
            <div class="form-group">
                <label for="correo">Correo electrónico:</label>
                <input type="email" id="correo" name="correo" required>
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" required>
            </div>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <div class="register-button">
            <form action="registro.php">
                <button type="submit">Registrarse</button>
            </form>
        </div>
    </div>
    <script src="script/scripts_pantalla_de_carga.js"></script>
</body>
</html>






<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    $sql = "SELECT * FROM usuarios WHERE correo='$correo' AND contraseña='$contraseña'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        if ($row['es_admin'] == 1) { // Verifica si el usuario es un administrador
            $_SESSION['admin'] = true;
            header("Location: administrador.php");
            exit();
        } else {
            $_SESSION['correo'] = $correo;
            header("Location: perfil.php");
            exit();
        }
    } else {
        // Si el usuario no está registrado, se establece una variable de sesión para indicarlo
        $_SESSION['no_registrado'] = true;
        // Redirige de nuevo al formulario de inicio de sesión
        header("Location: login.php"); 
        exit();
    }
}

$conn->close();
?>


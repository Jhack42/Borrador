<?php
session_start();
include 'db_connection.php'; // Archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizar los datos de entrada para prevenir inyección SQL
    $correo = mysqli_real_escape_string($conn, $_POST['correo']);
    $contraseña = mysqli_real_escape_string($conn, $_POST['contraseña']);

    // Hash de la contraseña para compararla con la almacenada en la base de datos
    $contraseña_hash = hash('sha256', $contraseña);

    // Consulta preparada para evitar la inyección SQL
    $sql = "SELECT * FROM usuarios WHERE correo=? AND contraseña=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $correo, $contraseña_hash);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Si el usuario es administrador
        if ($row['es_admin'] == 1) {
            $_SESSION['admin'] = true;
            header("Location: administrador.php"); // Redirige al panel de administrador
            exit();
        } else {
            $_SESSION['correo'] = $correo;
            header("Location: perfil.php"); // Redirige al perfil del usuario
            exit();
        }
    } else {
        // Si el usuario no está registrado, se establece una variable de sesión para indicarlo
        $_SESSION['no_registrado'] = true;
        // Redirige de nuevo al formulario de inicio de sesión
        header("Location: login.php"); 
        exit();
    }

    $stmt->close();
}

$conn->close();
?>

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
        <!-- Agregar un elemento para mostrar el mensaje de error -->
        <div class="error-message" id="error-message">Correo o contraseña inválidos</div>
        <form id="loginForm" action="#" method="post">
            <div class="form-group">
                <label for="correo">Correo electrónico:</label>
                <input type="email" id="correo" name="correo" required>
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" required>
            </div>
            <button type="submit" id="submit-btn">Iniciar Sesión</button>
        </form>
        <div class="register-button">
            <form action="registro.php">
                <button type="submit">Registrarse</button>
            </form>
        </div>
    </div>

    <script src="script/scripts_login.js"></script>
    <script src="script/scripts_pantalla_de_carga.js"></script>
</body>
</html>

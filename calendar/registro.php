<?php
include 'db_connection.php';

// Variable para almacenar el mensaje de registro
$mensaje_registro = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    $nombre = $_POST['nombre'];

    $sql = "INSERT INTO usuarios (correo, contraseña, nombre) VALUES ('$correo', '$contraseña', '$nombre')";

    if ($conn->query($sql) === TRUE) {
        // Registro exitoso
        $mensaje_registro = "¡Registro exitoso!";
        // Redirigir al usuario a la página de inicio de sesión
        header("Location: login.php");
        exit();
    } else {
        // Error en el registro
        $mensaje_registro = "Error al registrar: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="css/style_registro.css">
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
        <h2>Registro de Usuario</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="correo">Correo electrónico:</label>
                <input type="email" id="correo" name="correo" required>
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <button type="submit">Registrarse</button>
        </form>
        <?php if (!empty($mensaje_registro)): ?>
            <div class="mensaje"><?php echo $mensaje_registro; ?></div>
        <?php endif; ?>
        <a href="login.php">¿Ya tienes una cuenta? Inicia sesión</a>
    </div>
    <script src="script/scripts_pantalla_de_carga.js"></script>

</body>
</html>

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

        if ($row['es_admin'] == 1) {
            $_SESSION['admin'] = true;
            header("Location: administrador.php");
            exit();
        } else {
            $_SESSION['correo'] = $correo;
            header("Location: perfil.php");
            exit();
        }
    } else {
        $_SESSION['no_registrado'] = true;
        $_SESSION['mensaje_error'] = "No encontramos ninguna cuenta que coincida exactamente con los datos que ingresaste.";
        header("Location: login.php"); 
        exit();
    }
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
    <style>
        .error-message {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <?php 
            if(isset($_SESSION['mensaje_error'])) {
                echo '<p class="error-message">' . $_SESSION['mensaje_error'] . '</p>';
                unset($_SESSION['mensaje_error']); // Limpiar el mensaje de error
            }
        ?>
        <form id="loginForm" action="#" method="post">
            <div class="form-group">
                <label for="correo">Correo electrónico:</label>
                <input type="email" id="correo" name="correo" required value="<?php echo isset($_SESSION['no_registrado']) ? '' : (isset($_POST['correo']) ? $_POST['correo'] : ''); ?>">
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" required value="<?php echo isset($_SESSION['no_registrado']) ? '' : (isset($_POST['contraseña']) ? $_POST['contraseña'] : ''); ?>">
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

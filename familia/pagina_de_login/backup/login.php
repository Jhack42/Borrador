<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="login_style.css">
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
        <a href="registro.php">Registrarse</a>
    </div>
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

        if ($row['correo'] == 'admin@gmail.com' && $row['contraseña'] == 'admin') {
            $_SESSION['admin'] = true;
            header("Location: administrador.php");
            exit();
        } else {
            $_SESSION['correo'] = $correo;
            header("Location: perfil.php");
            exit();
        }
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos');</script>";
    }
}

$conn->close();
?>

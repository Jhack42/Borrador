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
        echo "<script>alert('Usuario o contraseña incorrectos');</script>";
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
</head>
<body>
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
</body>
</html>

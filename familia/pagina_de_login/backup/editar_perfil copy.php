<?php
session_start();
if (!isset($_SESSION['correo'])) {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

$correo = $_SESSION['correo'];
$sql = "SELECT * FROM usuarios WHERE correo='$correo'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

?>

<!-- Aquí va tu formulario para editar el perfil del usuario -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="editar_perfil_style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('imagen/pintura.jpg'); /* Ruta relativa a la carpeta donde se encuentra este archivo HTML */
            background-size: cover; /* Ajusta el tamaño de la imagen para cubrir todo el cuerpo */
            background-position: center; /* Centra la imagen en el cuerpo */
            background-repeat: no-repeat; /* Evita la repetición de la imagen */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Editar Perfil</h2>
        <form action="procesar_perfil.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <!-- Verifica si $row está definido antes de mostrar el valor -->
                <input type="text" id="nombre" name="nombre" value="<?php if(isset($row['nombre'])) { echo $row['nombre']; } ?>" required>
            </div>
            <div class="form-group">
                <label for="foto_perfil">Foto de perfil:</label>
                <input type="file" id="foto_perfil" name="foto_perfil">
            </div>
            <button type="submit">Guardar cambios</button>
        </form>
    </div>
</body>
</html>

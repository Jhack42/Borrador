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

// Verifica si se ha enviado un archivo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["foto_perfil"])) {
    $target_directory = "uploads/"; // Directorio donde se guardarán las fotos de perfil
    $target_file = $target_directory . basename($_FILES["foto_perfil"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verifica si el archivo es una imagen real
    $check = getimagesize($_FILES["foto_perfil"]["tmp_name"]);
    if ($check === false) {
        $uploadOk = 0;
    }

    // Verifica si el archivo ya existe
    if (file_exists($target_file)) {
        echo "Lo siento, el archivo ya existe.";
        $uploadOk = 0;
    }

    // Verifica el tamaño del archivo
    if ($_FILES["foto_perfil"]["size"] > 500000) {
        echo "Lo siento, tu archivo es demasiado grande.";
        $uploadOk = 0;
    }

    // Permite solo ciertos formatos de archivo
    $allowed_extensions = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowed_extensions)) {
        echo "Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF.";
        $uploadOk = 0;
    }

    // Verifica si $uploadOk está configurado en 0 por un error
    if ($uploadOk == 0) {
        echo "Lo siento, tu archivo no fue subido.";
    } else {
        // Si todo está bien, intenta subir el archivo
        if (move_uploaded_file($_FILES["foto_perfil"]["tmp_name"], $target_file)) {
            // Guarda la ruta de la imagen en la base de datos
            $ruta_imagen = $target_file;
            $sql_update = "UPDATE usuarios SET foto_perfil='$ruta_imagen' WHERE correo='$correo'";
            if ($conn->query($sql_update) === TRUE) {
                echo "¡La foto de perfil se ha subido correctamente!";
            } else {
                echo "Error al actualizar la foto de perfil: " . $conn->error;
            }
        } else {
            echo "Lo siento, hubo un error al subir tu archivo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Usuario</title>
    <link rel="stylesheet" href="perfil_style.css">
</head>
<body>
    <div class="container">
        <h2>Perfil del Usuario</h2>
        <div class="perfil-info">
            <p><strong>Nombre:</strong> <?php echo $row['nombre']; ?></p>
            <p><strong>Correo electrónico:</strong> <?php echo $row['correo']; ?></p>
            <!-- Mostrar la foto de perfil si está disponible -->
            <?php if (!empty($row['foto_perfil'])) { ?>
                <img src="imagen/<?php echo $row['foto_perfil']; ?>" alt="Foto de perfil">
            <?php } else { ?>
                <p>No hay foto de perfil</p>
            <?php } ?>
            <!-- Agrega más información del perfil aquí si es necesario -->
        </div>
        <div class="editar-perfil">
            <a href="editar_perfil.php">Editar perfil</a>
            <!-- Agrega un enlace para permitir al usuario editar su perfil -->
        </div>
        <div class="cambiar-contraseña">
            <a href="cambiar_contraseña.php">Cambiar contraseña</a>
            <!-- Agrega un enlace para permitir al usuario cambiar su contraseña -->
        </div>
        <div class="logout">
            <a href="logout.php">Cerrar sesión</a>
            <!-- Agrega un enlace para permitir al usuario cerrar sesión -->
        </div>
    </div>
</body>
</html>

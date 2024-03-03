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
    $target_directory = "imagen/"; // Directorio donde se guardarán las fotos de perfil
    $target_file = $target_directory . basename($_FILES["foto_perfil"]["name"]);
    
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verifica si el archivo es una imagen real o una imagen falsa
    $check = getimagesize($_FILES["foto_perfil"]["tmp_name"]);
    if ($check !== false) {
        // El archivo es una imagen real
        $uploadOk = 1;
    } else {
        // El archivo no es una imagen real
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
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
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
                // Mensaje de éxito y botón "Aceptar"
                echo "¡La foto de perfil se ha subido correctamente!<br>";
                echo '<button onclick="window.location.href=\'perfil.php\'">Aceptar</button>';
            } else {
                echo "Error al actualizar la foto de perfil: " . $conn->error;
            }
        } else {
            echo "Lo siento, hubo un error al subir tu archivo.";
        }
    }
}
?>

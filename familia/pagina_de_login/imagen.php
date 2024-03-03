<?php
// Conexión a la base de datos (debes llenar estos datos con los de tu propia base de datos)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pagina_de_login";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}

// Consulta SQL para obtener el nombre del archivo de la imagen
$sql = "SELECT nombre_archivo FROM foto WHERE id = 1"; // Suponiendo que deseas recuperar la imagen con id=1

$result = $conn->query($sql);

// Variable para almacenar el nombre del archivo de la imagen
$nombre_archivo = "";

if ($result->num_rows > 0) {
    // Si se encontró la imagen en la base de datos, recuperar el nombre del archivo
    $row = $result->fetch_assoc();
    $nombre_archivo = $row["nombre_archivo"];
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Imagen</title>
    <style>
        #imagenMcLovin {
            width: 300px; /* Ancho de la imagen */
            height: auto; /* Altura autoajustable para mantener la proporción */
        }
    </style>
</head>
<body>
    <h1>Imagen de McLovin</h1>
    <?php
    // Verificar si se recuperó un nombre de archivo de la base de datos
    if (!empty($nombre_archivo)) {
        // Mostrar la imagen si se recuperó el nombre del archivo
        echo '<img id="imagenMcLovin" src="imagen/' . $nombre_archivo . '" alt="Imagen">';
    } else {
        // Mostrar un mensaje si no se encontraron imágenes en la base de datos
        echo "No hay imagen.";
    }
    ?>

</body>
</html>

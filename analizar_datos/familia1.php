<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos de la Familia</title>
</head>
<body>

<?php
// Establecer la conexión con la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "familia";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL para obtener los datos de las personas y sus habilidades y hijos
$sql = "SELECT persona.*, habilidades.*, hijos.*
        FROM persona
        LEFT JOIN habilidades ON persona.id = habilidades.persona_id
        LEFT JOIN hijos ON persona.id = hijos.persona_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Datos de la Familia</h1>";
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        $nombre = $row['nombre'];
        $correo = $row['correo'];
        $habilidad = $row['habilidad'];
        $hijo_nombre = $row['hijo_nombre'];

        echo "<li><strong>Nombre:</strong> $nombre</li>";
        echo "<li><strong>Correo:</strong> $correo</li>";
        echo "<li><strong>Habilidad:</strong> $habilidad</li>";
        echo "<li><strong>Nombre del hijo:</strong> $hijo_nombre</li>";
        echo "<br>";
    }
    echo "</ul>";
} else {
    echo "No se encontraron resultados.";
}

$conn->close();
?>

</body>
</html>

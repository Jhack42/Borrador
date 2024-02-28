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
    $personas = array();
    while ($row = $result->fetch_assoc()) {
        $id_persona = $row['id'];
        $nombre = $row['nombre'];
        $correo = $row['correo'];
        $habilidad = $row['habilidad'];
        $hijo_nombre = $row['hijo_nombre'];

        // Agregar las habilidades a la persona correspondiente en el array
        if (!isset($personas[$id_persona])) {
            $personas[$id_persona] = array(
                'nombre' => $nombre,
                'correo' => $correo,
                'habilidades' => array(),
                'hijos' => array()
            );
        }
        if (!empty($habilidad)) {
            $personas[$id_persona]['habilidades'][] = $habilidad;
        }

        // Agregar los nombres de los hijos a la persona correspondiente en el array
        if (!empty($hijo_nombre)) {
            $personas[$id_persona]['hijos'][] = $hijo_nombre;
        }
    }

    // Imprimir los datos de cada persona
    foreach ($personas as $persona) {
        echo "<p><strong>Nombre:</strong> {$persona['nombre']}</p>";
        echo "<p><strong>Correo:</strong> {$persona['correo']}</p>";
        echo "<p><strong>Habilidades:</strong> " . implode(", ", $persona['habilidades']) . "</p>";
        echo "<p><strong>Nombres de los hijos:</strong> " . implode(", ", $persona['hijos']) . "</p>";
        echo "<br>";
    }
} else {
    echo "No se encontraron resultados.";
}

$conn->close();
?>

</body>
</html>

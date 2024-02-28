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
$sql = "SELECT persona.id, persona.nombre, persona.correo, habilidades.habilidad, hijos.hijo_nombre
        FROM persona
        LEFT JOIN habilidades ON persona.id = habilidades.persona_id
        LEFT JOIN hijos ON persona.id = hijos.persona_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Variable para almacenar la información de la persona actual
    $current_person_id = null;
    $current_person_info = null;
    
    while ($row = $result->fetch_assoc()) {
        $persona_id = $row['id'];
        $nombre = $row['nombre'];
        $correo = $row['correo'];
        $habilidad = $row['habilidad'];
        $hijo_nombre = $row['hijo_nombre'];

        // Si es una nueva persona, imprimir los datos de la persona anterior
        if ($persona_id !== $current_person_id) {
            // Imprimir los datos de la persona anterior
            if ($current_person_info !== null) {
                echo "<h3>Datos de la Persona</h3>";
                echo "<p><strong>Nombre:</strong> {$current_person_info['nombre']}</p>";
                echo "<p><strong>Correo:</strong> {$current_person_info['correo']}</p>";
                echo "<p><strong>Habilidades:</strong> {$current_person_info['habilidades']}</p>";
                echo "<p><strong>Nombres de los hijos:</strong> {$current_person_info['hijos']}</p>";
            }
            
            // Actualizar la información de la persona actual
            $current_person_info = array(
                'nombre' => $nombre,
                'correo' => $correo,
                'habilidades' => $habilidad ? $habilidad : 'N/A',
                'hijos' => $hijo_nombre ? $hijo_nombre : 'N/A'
            );
            
            $current_person_id = $persona_id;
        } else {
            // Si es la misma persona, concatenar las habilidades y los nombres de los hijos
            if ($habilidad) {
                $current_person_info['habilidades'] .= ", $habilidad";
            }
            if ($hijo_nombre) {
                $current_person_info['hijos'] .= ", $hijo_nombre";
            }
        }
    }

    // Imprimir los datos de la última persona
    echo "<h3>Datos de la Persona</h3>";
    echo "<p><strong>Nombre:</strong> {$current_person_info['nombre']}</p>";
    echo "<p><strong>Correo:</strong> {$current_person_info['correo']}</p>";
    echo "<p><strong>Habilidades:</strong> {$current_person_info['habilidades']}</p>";
    echo "<p><strong>Nombres de los hijos:</strong> {$current_person_info['hijos']}</p>";
    
} else {
    echo "No se encontraron resultados.";
}

$conn->close();
?>

</body>
</html>

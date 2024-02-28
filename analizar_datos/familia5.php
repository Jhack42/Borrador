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
$sql = "SELECT 
            persona.id,
            persona.nombre,
            persona.correo,
            GROUP_CONCAT(DISTINCT habilidades.habilidad ORDER BY habilidades.habilidad SEPARATOR ', ') AS habilidades,
            GROUP_CONCAT(DISTINCT hijos.hijo_nombre ORDER BY hijos.hijo_nombre SEPARATOR ', ') AS nombres_hijos
        FROM 
            persona
        LEFT JOIN 
            habilidades ON persona.id = habilidades.persona_id
        LEFT JOIN 
            hijos ON persona.id = hijos.persona_id
        GROUP BY 
            persona.id, persona.nombre, persona.correo";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<h3>Datos de la Persona</h3>";
        echo "<p><strong>Nombre:</strong> {$row['nombre']}</p>";
        echo "<p><strong>Correo:</strong> {$row['correo']}</p>";
        echo "<p><strong>Habilidades:</strong> {$row['habilidades']}</p>";
        echo "<p><strong>Nombres de los hijos:</strong> {$row['nombres_hijos']}</p>";
        echo "<hr>";
    }
} else {
    echo "No se encontraron resultados.";
}

$conn->close();
?>

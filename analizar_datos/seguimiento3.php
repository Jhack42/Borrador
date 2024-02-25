<?php
// Conexión a la base de datos
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'seguimiento');

$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conexion->connect_error) {
    die("Error al conectar a la base de datos: " . $conexion->connect_error);
}

// Consulta SQL para obtener la información del profesor y sus alumnos
$sql = "SELECT p.nombre AS profesor, s.id_salon, a.id_alumno, a.nombre AS nombre_alumno, a.edad, a.grado
        FROM profesores p
        INNER JOIN salon s ON p.id_profesor = s.id_profesor
        INNER JOIN clase c ON s.id_salon = c.id_salon
        INNER JOIN alumnos a ON c.id_alumno = a.id_alumno
        WHERE p.id_profesor = 1"; // Puedes cambiar el ID del profesor que deseas analizar

$resultado = $conexion->query($sql);

// Verificar si se encontraron resultados
if ($resultado->num_rows > 0) {
    // Imprimir la frase "El profesor..." solo una vez
    $primera_vez = true;

    while($fila = $resultado->fetch_assoc()) {
        // Si es la primera vez, imprimir la frase "El profesor..."
        if ($primera_vez) {
            echo "El profesor " . $fila["profesor"] . " está en el salón " . $fila["id_salon"] . " y sus alumnos son:<br>";
            echo "<table border='1'>";
            echo "<tr><th>ID Alumno</th><th>Nombre</th><th>Edad</th><th>Grado</th></tr>";

            // Cambiar a false para que no vuelva a imprimir la frase "El profesor..."
            $primera_vez = false;
        }
        
        // Imprimir información de cada alumno relacionado con el profesor
        echo "<tr><td>" . $fila["id_alumno"] . "</td><td>" . $fila["nombre_alumno"] . "</td><td>" . $fila["edad"] . "</td><td>" . $fila["grado"] . "</td></tr>";
    }

    echo "</table><br>"; // Cerrar la tabla después de imprimir todos los alumnos
} else {
    echo "No se encontraron resultados.";
}

// Liberar el resultado y cerrar la conexión
$resultado->free();
$conexion->close();
?>

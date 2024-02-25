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
$sql = "SELECT p.nombre AS profesor, s.id_salon, GROUP_CONCAT(a.nombre SEPARATOR ', ') AS alumnos
        FROM profesores p
        INNER JOIN salon s ON p.id_profesor = s.id_profesor
        INNER JOIN alumnos a ON s.id_alumno = a.id_alumno
        WHERE p.id_profesor = 1"; // Puedes cambiar el ID del profesor que deseas analizar

$resultado = $conexion->query($sql);

// Verificar si se encontraron resultados
if ($resultado->num_rows > 0) {
    // Imprimir los resultados
    while($fila = $resultado->fetch_assoc()) {
        echo "El profesor " . $fila["profesor"] . " está en el salón " . $fila["id_salon"] . " y sus alumnos son: " . $fila["alumnos"] . "<br>";
    }
} else {
    echo "No se encontraron resultados.";
}

// Liberar el resultado y cerrar la conexión
$resultado->free();
$conexion->close();
?>
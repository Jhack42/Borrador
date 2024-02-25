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

// Consulta para obtener los datos del profesor, curso, estudiantes, sesiones y evaluaciones
$query = "
    SELECT Profesores.nombre AS nombre_profesor, 
           Cursos.nombre AS nombre_curso, 
           Sesiones.seccion, 
           Estudiantes.nombre AS nombre_estudiante, 
           Estudiantes.apellido AS apellido_estudiante, 
           Sesiones.dia AS fecha_sesion, 
           Sesiones.hora AS hora_sesion, 
           Evaluaciones.nombre_evaluacion, 
           Evaluaciones.fecha AS fecha_evaluacion, 
           Evaluaciones.hora AS hora_evaluacion
    FROM Profesores
    JOIN Sesiones ON Profesores.id_profesor = Sesiones.id_profesor
    JOIN Cursos ON Sesiones.id_curso = Cursos.id_curso
    JOIN Estudiantes ON Sesiones.id_estudiante = Estudiantes.id_estudiante
    JOIN Evaluaciones ON Cursos.id_curso = Evaluaciones.id_curso";
    
$result = $conexion->query($query);

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Imprimir la bienvenida y detalles del ciclo
    $row = $result->fetch_assoc();
    echo "Bienvenido " . $row['nombre_profesor'] . " al ciclo 2022-1 <br>";
    echo $row['nombre_curso'] . " " . $row['seccion'] . "<br>";

    // Imprimir listado de estudiantes
    echo "<h3>Listado de estudiantes:</h3>";
    echo "<ul>";
    $result->data_seek(0); // Reiniciar el puntero del resultado
    while ($row = $result->fetch_assoc()) {
        echo "<li>" . $row['nombre_estudiante'] . " " . $row['apellido_estudiante'] . "</li>";
    }
    echo "</ul>";

    // Volver a la primera fila para obtener las sesiones y evaluaciones
    $result->data_seek(0);

    // Imprimir listado de sesiones
    echo "<h3>Listado de sesiones, fecha y hora:</h3>";
    echo "<table border='1'>";
    echo "<tr><th>Sesión</th><th>Fecha</th><th>Hora</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['seccion'] . "</td>";
        echo "<td>" . $row['fecha_sesion'] . "</td>";
        echo "<td>" . $row['hora_sesion'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    // Volver a la primera fila para obtener las evaluaciones
    $result->data_seek(0);

    // Imprimir listado de evaluaciones
    echo "<h3>Listado de evaluaciones, fecha y hora:</h3>";
    echo "<table border='1'>";
    echo "<tr><th>Evaluación</th><th>Fecha</th><th>Hora</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['nombre_evaluacion'] . "</td>";
        echo "<td>" . $row['fecha_evaluacion'] . "</td>";
        echo "<td>" . $row['hora_evaluacion'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    // Después de definir la consulta SQL
    echo "Consulta SQL: " . $query . "<br>";

    // Después de ejecutar la consulta
    if (!$result) {
        printf("Error: %s\n", $conexion->error);
    }

    // Después de intentar obtener los resultados
    if ($result->num_rows > 0) {
        echo "Se encontraron resultados.<br>";
    } else {
        echo "No se encontraron resultados.<br>";
    }

} else {
    echo "No se encontraron resultados.";
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>

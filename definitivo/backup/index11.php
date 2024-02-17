<?php
// Conexión a la base de datos
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'prueba2');

// Establecer conexión con la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

// Consulta SQL para seleccionar todos los registros de la tabla de inscripciones
$sql = "SELECT inscripciones.id, estudiantes.nombre AS nombre_estudiante, estudiantes.apellido AS apellido_estudiante, cursos.nombre AS nombre_curso, inscripciones.fecha_inscripcion 
        FROM inscripciones 
        INNER JOIN estudiantes ON inscripciones.estudiante_id = estudiantes.id 
        INNER JOIN cursos ON inscripciones.curso_id = cursos.id";

// Ejecutar la consulta
$resultado = $conexion->query($sql);

// Verificar si hay resultados
if ($resultado->num_rows > 0) {
    // Mostrar los datos de la tabla de inscripciones
    echo "<h2>Tabla de Inscripciones</h2>";
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Nombre Estudiante</th>
                <th>Apellido Estudiante</th>
                <th>Nombre Curso</th>
                <th>Fecha de Inscripción</th>
            </tr>";
    
    // Recorrer los resultados y mostrar cada registro
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>
                <td>".$fila['id']."</td>
                <td>".$fila['nombre_estudiante']."</td>
                <td>".$fila['apellido_estudiante']."</td>
                <td>".$fila['nombre_curso']."</td>
                <td>".$fila['fecha_inscripcion']."</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron registros en la tabla de inscripciones";
}

// Cerrar la conexión
$conexion->close();
?>

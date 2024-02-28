<?php
// Realizar la conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "seguimiento");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta SQL para obtener los datos
$query = "SELECT Profesores.nombre AS nombre_profesor, 
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

$resultado = $conexion->query($query);

// Verificar si se encontraron resultados
if ($resultado->num_rows > 0) {
    // Recorrer los resultados y guardarlos en la tabla "correo_de_bienvenida"
    while ($fila = $resultado->fetch_assoc()) {
        $nombre_profesor = $fila['nombre_profesor'];
        $nombre_curso = $fila['nombre_curso'];
        $seccion = $fila['seccion'];
        $nombre_estudiante = $fila['nombre_estudiante'];
        $apellido_estudiante = $fila['apellido_estudiante'];
        $fecha_sesion = $fila['fecha_sesion'];
        $hora_sesion = $fila['hora_sesion'];
        $nombre_evaluacion = $fila['nombre_evaluacion'];
        $fecha_evaluacion = $fila['fecha_evaluacion'];
        $hora_evaluacion = $fila['hora_evaluacion'];

        // Insertar los datos en la tabla "correo_de_bienvenida"
        $query_insert = "INSERT INTO correo_de_bienvenida (nombre_profesor, nombre_curso, seccion, nombre_estudiante, apellido_estudiante, fecha_sesion, hora_sesion, nombre_evaluacion, fecha_evaluacion, hora_evaluacion) 
        VALUES ('$nombre_profesor', '$nombre_curso', '$seccion', '$nombre_estudiante', '$apellido_estudiante', '$fecha_sesion', '$hora_sesion', '$nombre_evaluacion', '$fecha_evaluacion', '$hora_evaluacion')";

        if ($conexion->query($query_insert) === TRUE) {
            echo "Datos insertados en la tabla correo_de_bienvenida correctamente<br>";
        } else {
            echo "Error al insertar datos en la tabla correo_de_bienvenida: " . $conexion->error . "<br>";
        }
    }
} else {
    echo "<p>No se encontraron resultados.</p>";
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>

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

// Obtener los nombres de los profesores
$sql_profesores = "SELECT id_profesor, nombre FROM profesores";
$resultado_profesores = $conexion->query($sql_profesores);

// Consulta SQL para obtener la información del profesor y sus alumnos (inicialmente vacía)
$resultado_alumnos = null;

// Verificar si se ha enviado el formulario (si se seleccionó un profesor)
if (isset($_POST['profesor'])) {
    $id_profesor_seleccionado = $_POST['profesor'];

    // Consulta SQL para obtener los alumnos relacionados con el profesor seleccionado
    $sql_alumnos = "SELECT a.nombre AS nombre_alumno
                    FROM profesores p
                    INNER JOIN salon s ON p.id_profesor = s.id_profesor
                    INNER JOIN clase c ON s.id_salon = c.id_salon
                    INNER JOIN alumnos a ON c.id_alumno = a.id_alumno
                    WHERE p.id_profesor = $id_profesor_seleccionado";

    $resultado_alumnos = $conexion->query($sql_alumnos);

    if (!$resultado_alumnos) {
        die("Error al ejecutar la consulta: " . $conexion->error);
    }

    // Obtener el nombre del profesor seleccionado
    $sql_nombre_profesor = "SELECT nombre FROM profesores WHERE id_profesor = $id_profesor_seleccionado";
    $resultado_nombre_profesor = $conexion->query($sql_nombre_profesor);
    $nombre_profesor = $resultado_nombre_profesor->fetch_assoc()['nombre'];
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta de alumnos por profesor</title>
</head>
<body>

<h2>Consulta de alumnos por profesor</h2>

<form method="post" action="">
    <label for="profesor">Seleccione un profesor:</label>
    <select name="profesor" id="profesor">
        <?php
        // Mostrar opciones del menú desplegable con los nombres de los profesores
        while ($fila = $resultado_profesores->fetch_assoc()) {
            echo "<option value='" . $fila['id_profesor'] . "'>" . $fila['nombre'] . "</option>";
        }
        ?>
    </select>
    <button type="submit">Consultar</button>
</form>

<?php
// Mostrar resultados de la consulta si se seleccionó un profesor
if ($resultado_alumnos !== null && $resultado_alumnos->num_rows > 0) {
    echo "<h3>Resultados:</h3>";
    echo "El profesor $nombre_profesor está en el salón 1 y sus alumnos son:<br>";
    while($fila = $resultado_alumnos->fetch_assoc()) {
        // Imprimir información de cada alumno relacionado con el profesor
        echo "- " . $fila["nombre_alumno"] . "<br>";
    }
}

// Liberar el resultado y cerrar la conexión
$resultado_profesores->free();
if ($resultado_alumnos !== null) {
    $resultado_alumnos->free();
}
$conexion->close();
?>

</body>
</html>

<?php
// Establecer la zona horaria del sistema operativo Windows
date_default_timezone_set('America/Lima'); // Ajusta la zona horaria según tu ubicación

// Obtener la hora actual del sistema operativo Windows
$hora_actual = date("H:i:s");
echo "Hora actual del sistema operativo Windows: $hora_actual<br><br>";

define('PHP_EXECUTABLE', 'C:\xampp\php\php.exe');
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'programar_tarea_mysql4');

// Conexión a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener las tareas programadas
$sql = "SELECT id, fecha, hora, correo FROM tareas_programadas";
$result = $conn->query($sql);
?>

<!-- Tabla de datos -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Correo</th>
            <th>Tiempo Restante</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Mostrar resultados
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['fecha']}</td>";
            echo "<td>{$row['hora']}</td>";
            echo "<td>{$row['correo']}</td>";
            // Calcular tiempo restante y mostrar
            $currentDateTime = new DateTime();
            $taskDateTime = new DateTime($row['fecha'] . ' ' . $row['hora']);
            $interval = $currentDateTime->diff($taskDateTime);
            $timeLeft = $interval->format('%R%a días %H horas %I minutos');
            echo "<td>{$timeLeft}</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<!-- Contenido del correo electrónico -->
<?php
$htmlContent = "<!DOCTYPE html>
<html>
<head>
    <title>Contenido del Correo Electrónico</title>
</head>
<body>
    <h1>Contenido del Correo Electrónico</h1>
    <p>Aquí puedes escribir el contenido que deseas enviar por correo electrónico.</p>
</body>
</html>";
echo $htmlContent;
?>

<?php
// Cerrar la conexión a la base de datos
$conn->close();
?>

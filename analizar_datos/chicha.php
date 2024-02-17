<?php
// Conexión a la base de datos
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'prueba');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Error al conectar a la base de datos: " . $conn->connect_error);
}

// Realizar seguimiento de las claves foráneas de la tabla Docentes
$query_fk = "SELECT TABLE_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME 
             FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
             WHERE REFERENCED_TABLE_NAME='Docentes'";
$result_fk = $conn->query($query_fk);

if ($result_fk->num_rows > 0) {
    echo "<h3>Seguimiento de Claves Foráneas de la tabla Docentes:</h3>";
    echo "<table border='1'>";
    echo "<tr><th>Tabla</th><th>Columna</th><th>Tabla Foránea</th><th>Columna Foránea</th></tr>";
    while ($row_fk = $result_fk->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row_fk['TABLE_NAME']}</td>";
        echo "<td>{$row_fk['COLUMN_NAME']}</td>";
        echo "<td>{$row_fk['REFERENCED_TABLE_NAME']}</td>";
        echo "<td>{$row_fk['REFERENCED_COLUMN_NAME']}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No hay claves foráneas relacionadas con la tabla Docentes";
}

// Realizar un análisis de la tabla Evaluaciones relacionado con el DocenteID en la tabla Docentes
$query_evaluaciones = "SELECT * FROM Evaluaciones WHERE DocenteID = 1"; // Suponiendo que quieres analizar las evaluaciones del docente con ID 1
$result_evaluaciones = $conn->query($query_evaluaciones);

if ($result_evaluaciones->num_rows > 0) {
    echo "<h3>Análisis de la tabla Evaluaciones relacionado con el DocenteID 1:</h3>";
    echo "<table border='1'>";
    while ($row_evaluacion = $result_evaluaciones->fetch_assoc()) {
        echo "<tr>";
        foreach ($row_evaluacion as $key => $value) {
            echo "<td>$key: $value</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron resultados para el DocenteID 1 en la tabla Evaluaciones";
}

// Cerrar conexión
$conn->close();
?>

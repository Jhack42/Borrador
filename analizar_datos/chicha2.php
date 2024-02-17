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

// Obtener los datos de la tabla docente_bienvenida
$query_docente_bienvenida = "SELECT * FROM docente_bienvenida";
$result_docente_bienvenida = $conn->query($query_docente_bienvenida);

if ($result_docente_bienvenida->num_rows > 0) {
    while ($row_docente_bienvenida = $result_docente_bienvenida->fetch_assoc()) {
        // Utilizar los datos de la tabla docente_bienvenida en las consultas
        $tabla = $row_docente_bienvenida['tabla'];
        $columna = $row_docente_bienvenida['columna'];
        $claves_foranea = $row_docente_bienvenida['claves_foranea'];

        // Realizar seguimiento de las claves foráneas de la tabla Docentes
        $query_fk = "SELECT TABLE_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME 
                    FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                    WHERE REFERENCED_TABLE_NAME='$tabla' AND REFERENCED_COLUMN_NAME='$claves_foranea'";
        $result_fk = $conn->query($query_fk);

        if ($result_fk->num_rows > 0) {
            echo "<h3>Seguimiento de Claves Foráneas de la tabla $tabla:</h3>";
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
            echo "No hay claves foráneas relacionadas con la tabla $tabla";
        }

        // Realizar un análisis de la tabla Evaluaciones relacionado con el DocenteID en la tabla Docentes
        $query_evaluaciones = "SELECT * FROM $tabla WHERE $claves_foranea = 1"; // Suponiendo que quieres analizar las evaluaciones del docente con ID 1
        $result_evaluaciones = $conn->query($query_evaluaciones);

        if ($result_evaluaciones->num_rows > 0) {
            echo "<h3>Análisis de la tabla $tabla relacionado con el $claves_foranea 1:</h3>";
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
            echo "No se encontraron resultados para el $claves_foranea 1 en la tabla $tabla";
        }
    }
} else {
    echo "No se encontraron datos en la tabla docente_bienvenida";
}

// Cerrar conexión
$conn->close();
?>

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

// Realizar seguimiento de los FOREIGN KEYS utilizando los datos de la tabla docente_bienvenida
$query_docente_bienvenida = "SELECT * FROM docente_bienvenida";
$result_docente_bienvenida = $conn->query($query_docente_bienvenida);

if ($result_docente_bienvenida->num_rows > 0) {
    while ($row_docente_bienvenida = $result_docente_bienvenida->fetch_assoc()) {
        // Utilizar los datos de la tabla docente_bienvenida en las consultas
        $tabla = $row_docente_bienvenida['tabla'];
        $columna = $row_docente_bienvenida['columna'];
        $foreign_key_columna = $row_docente_bienvenida['foreign_key_columna'];
        $claves_foranea = $row_docente_bienvenida['claves_foranea'];
        $valor = $row_docente_bienvenida['valor_predeterminado'];
        $columna2 = $row_docente_bienvenida['columna2'];
        $foreign_key_columna2 = $row_docente_bienvenida['foreign_key_columna2'];
        $claves_foranea2 = $row_docente_bienvenida['claves_foranea2'];
        $valor2 = $row_docente_bienvenida['valor_predeterminado2'];

        // Realizar un análisis de la tabla relacionada con el FOREIGN KEY
        $query_evaluaciones = "SELECT * FROM $tabla WHERE $foreign_key_columna = $valor";
        $result_evaluaciones = $conn->query($query_evaluaciones);

        if ($result_evaluaciones->num_rows > 0) {
            echo "<h3>Análisis de la tabla $tabla relacionado con el $foreign_key_columna $valor:</h3>";
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
            echo "No se encontraron resultados para el $foreign_key_columna $valor en la tabla $tabla";
        
        }


        // Segunda consulta para el segundo FOREIGN KEY
        $query_evaluaciones2 = "SELECT * FROM $tabla WHERE $foreign_key_columna2 = $valor2";
        $result_evaluaciones2 = $conn->query($query_evaluaciones2);

        if ($result_evaluaciones2->num_rows > 0) {
            echo "<h3>Análisis de la tabla $tabla relacionado con el $foreign_key_columna2 $valor2:</h3>";
            echo "<table border='1'>";
            while ($row_evaluacion2 = $result_evaluaciones2->fetch_assoc()) {
                echo "<tr>";
                foreach ($row_evaluacion2 as $key => $value) {
                    echo "<td>$key: $value</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No se encontraron resultados para el $foreign_key_columna2 $valor2 en la tabla $tabla";
        }





    }
} else {
    echo "No hay datos en la tabla docente_bienvenida";
}

// Cerrar conexión
$conn->close();
?>

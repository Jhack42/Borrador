<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Tablas</title>
</head>
<body>

<h2>Consulta de Tablas</h2>

<form method="POST" action="">
    <label for="tabla">Nombre de la tabla:</label>
    <input type="text" id="tabla" name="tabla">
    <input type="submit" value="Consultar">
</form>

<form method="POST" action="">
    <label for="tabla">Nombre de la tabla:</label>
    <input type="text" id="tabla" name="tabla">
    <input type="submit" value="Consultar">
</form>

<?php
// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos
    define('DB_HOST', '127.0.0.1');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'prueba');

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Obtener el nombre de la tabla del formulario
    $tabla = $_POST['tabla'];

    // Realizar la consulta a la tabla especificada
    $query = "SELECT * FROM $tabla";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo "<h3>Resultados de la consulta:</h3>";
        echo "<table border='1'>";
        // Mostrar los datos de la consulta
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $key => $value) {
                echo "<td>$key: $value</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron resultados para la tabla $tabla";
    }

    // Realizar seguimiento de las claves foráneas
    $query_fk = "SELECT TABLE_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME 
                 FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                 WHERE REFERENCED_TABLE_NAME='$tabla'";
    $result_fk = $conn->query($query_fk);

    if ($result_fk->num_rows > 0) {
        echo "<h3>Seguimiento de Claves Foráneas:</h3>";
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

    // Cerrar conexión
    $conn->close();
}
?>

</body>
</html>

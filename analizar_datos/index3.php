<?php

// Conexión a la base de datos
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'prueba');

// Crear conexión
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Inicializar array para almacenar la información de las tablas
$database_info = array();

// Obtener nombres de las tablas en la base de datos
$tables_query = "SHOW TABLES";
$tables_result = $conn->query($tables_query);

if ($tables_result->num_rows > 0) {
    while ($row = $tables_result->fetch_assoc()) {
        $table_name = $row["Tables_in_" . DB_NAME];
        $table_info = array();

        // Obtener información de la estructura de la tabla
        $columns_query = "DESCRIBE $table_name";
        $columns_result = $conn->query($columns_query);

        if ($columns_result->num_rows > 0) {
            while ($column_row = $columns_result->fetch_assoc()) {
                $table_info['columnas'][] = $column_row;
            }
        } else {
            $table_info['columnas'] = array();
        }

        // Obtener datos de la tabla
        $data_query = "SELECT * FROM $table_name";
        $data_result = $conn->query($data_query);

        if ($data_result->num_rows > 0) {
            while ($data_row = $data_result->fetch_assoc()) {
                $table_info['datos'][] = $data_row;
            }
        } else {
            $table_info['datos'] = array();
        }

        // Guardar la información de la tabla en el array principal
        $database_info[$table_name] = $table_info;
    }
} else {
    echo "La base de datos no contiene tablas.";
}

// Cerrar conexión
$conn->close();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de la base de datos</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<?php
// Procesar e imprimir la información obtenida
foreach ($database_info as $table_name => $table_info) {
    echo "<h2>Tabla: $table_name</h2>";
    
    // Mostrar las columnas de la tabla
    echo "<h3>Columnas:</h3>";
    echo "<table>";
    echo "<tr><th>Nombre de la Columna</th><th>Tipo de Dato</th><th>Nulo</th><th>Clave Primaria</th><th>Clave Foránea</th><th>Valor Predeterminado</th><th>Extras</th></tr>";
    foreach ($table_info['columnas'] as $column_info) {
        echo "<tr>";
        echo "<td>{$column_info['Field']}</td>";
        echo "<td>{$column_info['Type']}</td>";
        echo "<td>{$column_info['Null']}</td>";
        echo "<td>{$column_info['Key']}</td>";
        echo "<td>{$column_info['Extra']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Mostrar los datos de la tabla
    echo "<h3>Datos:</h3>";
    echo "<table>";
    echo "<tr>";
    foreach ($table_info['columnas'] as $column_info) {
        echo "<th>{$column_info['Field']}</th>";
    }
    echo "</tr>";
    foreach ($table_info['datos'] as $data_row) {
        echo "<tr>";
        foreach ($data_row as $value) {
            echo "<td>$value</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    echo "<br>";
}
?>

</body>
</html>

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

// Obtener nombres de las tablas en la base de datos
$tables_query = "SHOW TABLES";
$tables_result = $conn->query($tables_query);

if ($tables_result->num_rows > 0) {
    while ($row = $tables_result->fetch_assoc()) {
        $table_name = $row["Tables_in_" . DB_NAME];
        echo "Tabla: $table_name<br>";

        // Obtener información de la estructura de la tabla
        $columns_query = "DESCRIBE $table_name";
        $columns_result = $conn->query($columns_query);

        if ($columns_result->num_rows > 0) {
            echo "Columnas:<br>";
            while ($column_row = $columns_result->fetch_assoc()) {
                echo "- " . $column_row["Field"] . "<br>";
            }
        } else {
            echo "La tabla $table_name no tiene columnas.<br>";
        }

        // Obtener datos de la tabla
        $data_query = "SELECT * FROM $table_name";
        $data_result = $conn->query($data_query);

        if ($data_result->num_rows > 0) {
            echo "Datos:<br>";
            while ($data_row = $data_result->fetch_assoc()) {
                print_r($data_row);
                echo "<br>";
            }
        } else {
            echo "La tabla $table_name no tiene datos.<br>";
        }
        echo "<br>";
    }
} else {
    echo "La base de datos no contiene tablas.";
}

// Cerrar conexión
$conn->close();
?>

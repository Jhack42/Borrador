<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Tablas</title>
</head>
<body>

<h2>Consulta de Tablas</h2>

<!-- Formulario para la consulta principal -->
<form method="POST" action="">
    <h3>Consulta de Tablas</h3>
    <label for="tabla">Nombre de la tabla:</label>
    <select name="tabla" id="tabla">
        <!-- Aquí debes obtener las tablas y mostrarlas como opciones -->
        <?php
        // Conexión a la base de datos
        define('DB_HOST', '127.0.0.1');
        define('DB_USER', 'root');
        define('DB_PASSWORD', '');
        define('DB_NAME', 'prueba');

        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // Obtener las tablas de la base de datos
        $query_tablas = "SHOW TABLES";
        $result_tablas = $conn->query($query_tablas);

        if ($result_tablas->num_rows > 0) {
            while ($row_tabla = $result_tablas->fetch_assoc()) {
                echo "<option value='{$row_tabla['Tables_in_' . DB_NAME]}'>{$row_tabla['Tables_in_' . DB_NAME]}</option>";
            }
        }
        ?>
    </select>
    <br><br>
    <input type="submit" value="Realizar Consulta">
</form>

<!-- Procesamiento de la consulta principal -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tabla'])) {
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
}
?>

<!-- Formulario para la consulta secundaria -->
<form method="POST" action="">
    <h3>Seguimiento de Claves Foráneas</h3>
    <label for="tabla_relacionada">Seleccionar tabla:</label>
    <select name="tabla_relacionada" id="tabla_relacionada">
        <!-- Aquí debes obtener las tablas relacionadas y mostrarlas como opciones -->
        <?php
        // Obtener las tablas de la base de datos
        $query_tablas_fk = "SELECT DISTINCT TABLE_NAME 
                             FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                             WHERE REFERENCED_TABLE_SCHEMA = '" . DB_NAME . "'";
        $result_tablas_fk = $conn->query($query_tablas_fk);

        if ($result_tablas_fk->num_rows > 0) {
            while ($row_tabla_fk = $result_tablas_fk->fetch_assoc()) {
                echo "<option value='{$row_tabla_fk['TABLE_NAME']}'>{$row_tabla_fk['TABLE_NAME']}</option>";
            }
        }
        ?>
    </select>
    <br><br>
    <label for="id">ID:</label>
    <select name="id" id="id">
        <!-- Aquí debes obtener las IDs disponibles y mostrarlas como opciones -->
        <?php
        // Puedes implementar esta parte según tus necesidades
        ?>
    </select>
    <br><br>
    <input type="submit" value="Realizar Consulta">
</form>

<!-- Procesamiento de la consulta secundaria -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tabla_relacionada']) && isset($_POST['id'])) {
    // Realizar la consulta secundaria aquí
}
?>

</body>
</html>

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
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
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

        if ($result_tablas) {
            if ($result_tablas->num_rows > 0) {
                while ($row_tabla = $result_tablas->fetch_assoc()) {
                    echo "<option value='{$row_tabla['Tables_in_' . DB_NAME]}'>{$row_tabla['Tables_in_' . DB_NAME]}</option>";
                }
            } else {
                echo "No se encontraron tablas.";
            }
        } else {
            echo "Error en la consulta de tablas: " . $conn->error;
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

    if ($result) {
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
    } else {
        echo "Error en la consulta: " . $conn->error;
    }
}
?>

<!-- Formulario para la selección de ID -->
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <h3>Selección de ID</h3>
    <label for="id">Selección de ID:</label>
    <select name="id" id="id">
        <!-- Puedes dejarlo vacío hasta que se seleccione una tabla -->
        <option value="">Selecciona un ID primero</option>
    </select>
    <br><br>
    <input type="submit" value="Seleccionar ID">
</form>

<!-- Formulario para la selección de tabla relacionada -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Procesar la selección del ID
    $id_seleccionado = $_POST['id'];

    // Obtener las tablas relacionadas con el ID seleccionado (aquí deberías obtener las tablas relacionadas según tu lógica)
    $tablas_relacionadas = array('tabla1', 'tabla2', 'tabla3'); // Cambia esto según tu lógica

    // Mostrar el formulario para seleccionar la tabla relacionada
    echo "<form method='POST' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
    echo "<h3>Selección de tabla relacionada</h3>";
    echo "<label for='tabla_relacionada'>Seleccione una tabla relacionada:</label>";
    echo "<select name='tabla_relacionada' id='tabla_relacionada'>";
    foreach ($tablas_relacionadas as $tabla_relacionada) {
        echo "<option value='$tabla_relacionada'>$tabla_relacionada</option>";
    }
    echo "</select>";
    echo "<br><br>";
    echo "<input type='submit' value='Seleccionar Tabla Relacionada'>";
    echo "</form>";
}

// Cerrar conexión
$conn->close();
?>

</body>
</html>

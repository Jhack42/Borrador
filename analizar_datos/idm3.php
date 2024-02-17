<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Tablas</title>
</head>
<body>

<h2>Consulta de Tablas</h2>

<?php
// Definir constantes de conexión a la base de datos
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'prueba');

// Inicializar la variable para los resultados de la consulta
$resultados = [];

// Conectar a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Error al conectar a la base de datos: " . $conn->connect_error);
}

// Procesar la selección de la tabla y mostrar los resultados
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['tabla'])) {
    $tabla_seleccionada = $_POST['tabla'];
    $query = "SELECT * FROM $tabla_seleccionada";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $resultados[] = $row;
        }
    } else {
        echo "No se encontraron resultados para la tabla $tabla_seleccionada";
    }
}
?>

<!-- Formulario para la selección de la tabla -->
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="tabla">Nombre de la tabla:</label>
    <select name="tabla" id="tabla">
        <!-- Aquí debes obtener las tablas y mostrarlas como opciones -->
        <?php
        // Obtener las tablas de la base de datos
        $query_tablas = "SHOW TABLES";
        $result_tablas = $conn->query($query_tablas);

        if ($result_tablas->num_rows > 0) {
            while ($row_tabla = $result_tablas->fetch_assoc()) {
                echo "<option value='{$row_tabla['Tables_in_' . DB_NAME]}'>{$row_tabla['Tables_in_' . DB_NAME]}</option>";
            }
        } else {
            echo "No se encontraron tablas.";
        }
        ?>
    </select>
    <br><br>
    <input type="submit" value="Seleccionar Tabla">
</form>

<!-- Mostrar los resultados de la consulta -->
<?php if (!empty($resultados)) : ?>
    <h3>Resultados de la consulta:</h3>
    <table border='1'>
        <tr>
            <?php foreach ($resultados[0] as $key => $value) : ?>
                <th><?php echo $key; ?></th>
            <?php endforeach; ?>
        </tr>
        <?php foreach ($resultados as $row) : ?>
            <tr>
                <?php foreach ($row as $value) : ?>
                    <td><?php echo $value; ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?php
// Cerrar conexión
$conn->close();
?>

</body>
</html>

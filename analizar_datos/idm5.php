<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selección de Clave Primaria de Docentes</title>
</head>
<body>

<h2>Selección de Clave Primaria de Docentes</h2>

<?php
// Definir constantes de conexión a la base de datos
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'prueba');

// Conectar a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Error al conectar a la base de datos: " . $conn->connect_error);
}

// Procesar la selección de la tabla y obtener sus claves primarias
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['tabla'])) {
    $tabla_seleccionada = $_POST['tabla'];
    $stmt = $conn->prepare("SHOW COLUMNS FROM $tabla_seleccionada");
    $stmt->execute();
    $result = $stmt->get_result();
    $claves_primarias = [];

    while ($row = $result->fetch_assoc()) {
        if ($row['Key'] == 'PRI') {
            $claves_primarias[] = $row['Field'];
        }
    }
    $stmt->close();
}

// Procesar la selección de la clave primaria
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['claves_primarias'])) {
    $clave_seleccionada = $_POST['claves_primarias'];
    $mensaje = "La clave primaria seleccionada fue: $clave_seleccionada";
}
?>

<!-- Formulario para la selección de la tabla -->
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="tabla">Nombre de la tabla:</label>
    <select name="tabla" id="tabla">
        <!-- Obtener las tablas de la base de datos -->
        <?php
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

<!-- Formulario para la selección de la clave primaria -->
<?php if (!empty($claves_primarias)) : ?>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="claves_primarias">Seleccione una clave primaria:</label>
        <select name="claves_primarias" id="claves_primarias">
            <?php foreach ($claves_primarias as $clave) : ?>
                <option value="<?php echo $clave; ?>"><?php echo $clave; ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <input type="submit" value="Seleccionar Clave Primaria">
    </form>
<?php else : ?>
    <p>No hay claves primarias disponibles para la tabla seleccionada.</p>
<?php endif; ?>

<?php
echo $mensaje ?? '';
?>
</body>
</html>

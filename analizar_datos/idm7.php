<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selección de Clave Primaria de Tabla</title>
</head>
<body>

<h2>Selección de Clave Primaria de Tabla</h2>

<?php
// Definir constantes de conexión a la base de datos
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'prueba');

// Función para obtener las claves primarias de la tabla seleccionada
function obtener_claves_primarias($conn, $tabla) {
    $stmt = $conn->prepare("SHOW KEYS FROM $tabla WHERE Key_name = 'PRIMARY'");
    $stmt->execute();
    $result = $stmt->get_result();

    $claves_primarias = array();
    while ($row = $result->fetch_assoc()) {
        $claves_primarias[] = $row['Column_name'];
    }

    $stmt->close();

    return $claves_primarias;
}

// Inicializar la variable $mensaje
$mensaje = "";

// Conectar a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Error al conectar a la base de datos: " . $conn->connect_error);
}

// Procesar la selección de la tabla
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['tabla'])) {
    $tabla_seleccionada = $_POST['tabla'];
    $claves_primarias = obtener_claves_primarias($conn, $tabla_seleccionada);
}

// Procesar la selección de la clave primaria
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['claves_primarias'])) {
    $clave_seleccionada = $_POST['claves_primarias'];
    $mensaje = "La clave primaria seleccionada fue: $clave_seleccionada";
}
?>

<!-- Formulario para la selección de la tabla -->
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="tabla">Seleccione una tabla:</label>
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
            echo "<option value=''>No se encontraron tablas.</option>";
        }
        ?>
    </select>
    <br><br>
    <input type="submit" value="Seleccionar Tabla">
</form>

<!-- Formulario para la selección de la clave primaria -->
<?php if (!empty($claves_primarias)): ?>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="claves_primarias">Seleccione una clave primaria:</label>
    <select name="claves_primarias" id="claves_primarias">
        <?php
        foreach ($claves_primarias as $clave_primaria) {
            echo "<option value='$clave_primaria'>$clave_primaria</option>";
        }
        ?>
    </select>
    <br><br>
    <input type="submit" value="Seleccionar Clave Primaria">
</form>
<?php endif; ?>

<?php
echo $mensaje;
?>
</body>
</html>

<?php
// Definir constantes de conexión a la base de datos
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'prueba');

// Función para obtener las claves primarias de los docentes
function obtener_claves_primarias_docentes($conn) {
    $stmt = $conn->prepare("SELECT DocenteID FROM Docentes");
    $stmt->execute();
    $result = $stmt->get_result();

    $claves_primarias = array();
    while ($row = $result->fetch_assoc()) {
        $claves_primarias[] = $row['DocenteID'];
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

// Obtener las claves primarias de los docentes
$claves_primarias = obtener_claves_primarias_docentes($conn);

// Cerrar conexión a la base de datos
$conn->close();

// Procesar la selección de la clave primaria
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['claves_primarias'])) {
    $clave_seleccionada = $_POST['claves_primarias'];
    $mensaje = "El ID seleccionado fue: $clave_seleccionada";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selección de Clave Primaria de Docentes</title>
</head>
<body>

<h2>Selección de Clave Primaria de Docentes</h2>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="claves_primarias">Seleccione un DocenteID:</label>
    <select name="claves_primarias" id="claves_primarias">
        <?php
        if (!empty($claves_primarias)) {
            foreach ($claves_primarias as $clave_primaria) {
                echo "<option value='$clave_primaria'>$clave_primaria</option>";
            }
        } else {
            echo "<option value=''>No hay claves primarias disponibles</option>";
        }
        ?>
    </select>
    <br><br>
    <input type="submit" value="Seleccionar Clave Primaria">
</form>

<?php
echo $mensaje;
?>
</body>
</html>

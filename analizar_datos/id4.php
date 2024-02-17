<?php

// Definir constantes de conexión a la base de datos
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'prueba');

// Función para obtener las claves primarias de los docentes
function obtener_claves_primarias_docentes($conn) {
  $query = "SHOW KEYS FROM Docentes WHERE Key_name = 'PRIMARY'"; // Consulta para obtener las claves primarias
  $result = $conn->query($query);

  if ($result && $result->num_rows > 0) {
    $claves_primarias = array();
    while ($row = $result->fetch_assoc()) {
      $claves_primarias[] = $row['Column_name']; // Agregar el nombre de la columna de la clave primaria
    }
    return $claves_primarias;
  } else {
    return null;
  }
}

// Función para procesar la selección de la clave primaria
function procesar_seleccion_clave_primaria($clave_primaria) {
  return "Clave primaria seleccionada: $clave_primaria";
}

// Conectar a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Obtener las claves primarias de los docentes
$claves_primarias_docentes = obtener_claves_primarias_docentes($conn);

// Procesar la selección de la clave primaria
$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['clave_primaria'])) {
  $clave_primaria_seleccionada = $_POST['clave_primaria'];
  $mensaje = procesar_seleccion_clave_primaria($clave_primaria_seleccionada);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Selección de Claves Primarias de Docentes</title>
</head>
<body>

<h2>Selección de Claves Primarias de Docentes</h2>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <label for="clave_primaria">Seleccione una Clave Primaria:</label>
  <select name="clave_primaria" id="clave_primaria">
    <?php
    if ($claves_primarias_docentes !== null) {
      foreach ($claves_primarias_docentes as $clave_primaria) {
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

// Cerrar conexión a la base de datos
$conn->close();
?>

</body>
</html>

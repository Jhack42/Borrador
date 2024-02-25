<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Consulta SQL para obtener los datos de la tabla Cliente
$sql = "SELECT * FROM Cliente";
$resultado = $conexion->query($sql);
// Consulta SQL para obtener los datos de la tabla Cliente
$sql = "SELECT * FROM Producto";
$resultado2 = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
    <link rel="stylesheet" href="estilos.css">

</head>
<body>

<h2>Tabla de Clientes</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Correo Electrónico</th>
        <th>Dirección</th>
        <th>Ciudad</th>
        <th>País</th>
        <th>Teléfono</th>
    </tr>
    <?php
    // Mostrar los datos de la tabla Cliente en la tabla HTML
    if ($resultado->num_rows > 0) {
        while($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$fila["ID"]."</td>";
            echo "<td>".$fila["Nombre"]."</td>";
            echo "<td>".$fila["Apellido"]."</td>";
            echo "<td>".$fila["CorreoElectronico"]."</td>";
            echo "<td>".$fila["Direccion"]."</td>";
            echo "<td>".$fila["Ciudad"]."</td>";
            echo "<td>".$fila["Pais"]."</td>";
            echo "<td>".$fila["Telefono"]."</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No hay clientes</td></tr>";
    }
    ?>
</table>

</body><br>
</html>
<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Descripcion</th>
        <th>Precio</th>
        <th>Categoria</th>
    </tr>
    <?php
    // Mostrar los datos de la tabla Cliente en la tabla HTML
    if ($resultado2->num_rows > 0) {
        while($fila = $resultado2->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$fila["ID"]."</td>";
            echo "<td>".$fila["Nombre"]."</td>";
            echo "<td>".$fila["Descripcion"]."</td>";
            echo "<td>".$fila["Precio"]."</td>";
            echo "<td>".$fila["Categoria"]."</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No hay clientes</td></tr>";
    }
    ?>
</table><br>
</body>
</html>

<?php
// Cerrar la conexión a la base de datos
$conexion->close();
?>

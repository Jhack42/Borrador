<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Consulta SQL para obtener información relevante para el análisis de ventas
$sqlVentas = "SELECT c.Nombre AS Cliente, p.Nombre AS Producto, dp.Cantidad, dp.PrecioUnitario
              FROM Cliente c
              INNER JOIN Pedido pd ON c.ID = pd.ClienteID
              INNER JOIN DetallePedido dp ON pd.ID = dp.PedidoID
              INNER JOIN Producto p ON dp.ProductoID = p.ID";

$resultadoVentas = $conexion->query($sqlVentas);

if ($resultadoVentas->num_rows > 0) {
    // Inicializar variables para el análisis
    $totalVentas = 0;
    $clientes = [];
    $productos = [];

    // Procesar los datos de ventas
    while($fila = $resultadoVentas->fetch_assoc()) {
        // Calcular el total de ventas
        $totalVentas += $fila['Cantidad'] * $fila['PrecioUnitario'];

        // Contar los clientes
        $clientes[$fila['Cliente']] = 1;

        // Contar los productos
        $productos[$fila['Producto']] = 1;
    }

    // Cerrar la sección PHP antes de comenzar con el HTML
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análisis de Ventas</title>
</head>
<body>
    <h2>Análisis de Ventas</h2>
    <p>Total de Ventas: S/<?php echo number_format($totalVentas, 2); ?></p>
    <p>Cantidad de Clientes: <?php echo count($clientes); ?></p>
    <p>Cantidad de Productos Vendidos: <?php echo count($productos); ?></p>

    <?php
    // Consulta SQL para obtener el seguimiento de cada cliente
    $sqlSeguimientoClientes = "SELECT c.ID AS ClienteID, c.Nombre AS NombreCliente, p.Nombre AS NombreProducto, dp.Cantidad, dp.PrecioUnitario, pd.FechaPedido
    FROM Cliente c
    INNER JOIN Pedido pd ON c.ID = pd.ClienteID
    INNER JOIN DetallePedido dp ON pd.ID = dp.PedidoID
    INNER JOIN Producto p ON dp.ProductoID = p.ID";



    $resultadoSeguimientoClientes = $conexion->query($sqlSeguimientoClientes);

    if ($resultadoSeguimientoClientes->num_rows > 0) {
        // Mostrar el seguimiento de cada cliente en una tabla HTML
    ?>
    <h2>Seguimiento de Clientes</h2>
    <table border='1'>
        <tr>
            <th>Cliente</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Fecha Pedido</th>
        </tr>
        <?php
            while($fila = $resultadoSeguimientoClientes->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $fila['NombreCliente'] . "</td>";
                echo "<td>" . $fila['NombreProducto'] . "</td>";
                echo "<td>" . $fila['Cantidad'] . "</td>";
                echo "<td>" . $fila['PrecioUnitario'] . "</td>";
                echo "<td>" . $fila['FechaPedido'] . "</td>";
                echo "</tr>";
            }
        ?>
    </table>
    <?php
    } else {
        echo "No hay datos disponibles para mostrar.";
    }
} else {
    echo "No hay datos disponibles para analizar.";
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
</body>
</html>

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

    // Generar el texto de análisis
    echo "Análisis de Ventas:\n";
    echo "Total de Ventas: S/" . number_format($totalVentas, 2) . "\n";
    echo "Cantidad de Clientes: " . count($clientes) . "\n";
    echo "Cantidad de Productos Vendidos: " . count($productos) . "\n";
} else {
    echo "No hay datos disponibles para analizar.";
}

$sqlSeguimientoClientes = "SELECT c.ID AS ClienteID, c.Nombre AS NombreCliente, p.Nombre AS NombreProducto, dp.Cantidad, dp.PrecioUnitario, pd.FechaPedido
              FROM Cliente c
              INNER JOIN Pedido pd ON c.ID = pd.ClienteID
              INNER JOIN DetallePedido dp ON pd.ID = dp.PedidoID
              INNER JOIN Producto p ON dp.ProductoID = p.ID";

$resultadoSeguimientoClientes = $conexion->query($sqlSeguimientoClientes);

if ($resultadoSeguimientoClientes->num_rows > 0) {
    // Procesar los datos
    while($fila = $resultadoSeguimientoClientes->fetch_assoc()) {
        echo "Cliente: " . $fila['NombreCliente'] . "\n";
        echo "Producto: " . $fila['NombreProducto'] . "\n";
        echo "Cantidad: " . $fila['Cantidad'] . "\n";
        echo "Precio Unitario: " . $fila['PrecioUnitario'] . "\n";
        echo "Fecha Pedido: " . $fila['FechaPedido'] . "\n";
        echo "------------------------------------\n";
    }
} else {
    echo "No hay datos disponibles para mostrar.";
}


// Cerrar la conexión a la base de datos
$conexion->close();
?>
echo "<h2>Análisis de Ventas</h2>";
echo "<p>Total de Ventas: S/" . number_format($totalVentas, 2) . "</p>";
echo "<p>Cantidad de Clientes: " . count($clientes) . "</p>";
echo "<p>Cantidad de Productos Vendidos: " . count($productos) . "</p>";

echo "<h2>Seguimiento de Clientes</h2>";

if ($resultadoSeguimientoClientes->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Cliente</th><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Fecha Pedido</th></tr>";

    while($fila = $resultadoSeguimientoClientes->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $fila['NombreCliente'] . "</td>";
        echo "<td>" . $fila['NombreProducto'] . "</td>";
        echo "<td>" . $fila['Cantidad'] . "</td>";
        echo "<td>" . $fila['PrecioUnitario'] . "</td>";
        echo "<td>" . $fila['FechaPedido'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No hay datos disponibles para mostrar.";
}

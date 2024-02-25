<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Consulta SQL para obtener información relevante
// Consulta SQL para obtener información relevante
$sql = "SELECT c.Nombre AS Cliente, p.Nombre AS Producto, dp.Cantidad, dp.PrecioUnitario
        FROM Cliente c
        INNER JOIN Pedido pd ON c.ID = pd.ClienteID
        INNER JOIN DetallePedido dp ON pd.ID = dp.PedidoID
        INNER JOIN Producto p ON dp.ProductoID = p.ID";


$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    // Inicializar variables para el análisis
    $totalVentas = 0;
    $clientes = [];
    $productos = [];

    // Procesar los datos
    while($fila = $resultado->fetch_assoc()) {
        // Calcular el total de ventas
        $totalVentas += $fila['Cantidad'] * $fila['PrecioUnitario'];

        // Contar los clientes
        $clientes[$fila['Cliente']] = isset($clientes[$fila['Cliente']]) ? $clientes[$fila['Cliente']] + 1 : 1;

        // Contar los productos
        $productos[$fila['Producto']] = isset($productos[$fila['Producto']]) ? $productos[$fila['Producto']] + 1 : 1;
    }

    // Generar el texto de análisis
    echo "Análisis de Ventas:\n";
    echo "Total de Ventas: S/" . number_format($totalVentas, 2) . "\n";
    echo "Cantidad de Clientes: " . count($clientes) . "\n";
    echo "Cantidad de Productos Vendidos: " . count($productos) . "\n";
} else {
    echo "No hay datos disponibles para analizar.";
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>

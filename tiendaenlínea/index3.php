<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Consulta SQL para obtener los datos de los clientes
$sqlClientes = "SELECT c.ID AS ClienteID, c.Nombre AS NombreCliente, c.Apellido AS ApellidoCliente, c.CorreoElectronico AS CorreoCliente, c.Direccion AS DireccionCliente, c.Ciudad AS CiudadCliente, c.Pais AS PaisCliente, c.Telefono AS TelefonoCliente FROM Cliente c";
$resultadoClientes = $conexion->query($sqlClientes);

// Consulta SQL para obtener los datos de los productos
$sqlProductos = "SELECT p.ID AS ProductoID, p.Nombre AS NombreProducto, p.Descripcion AS DescripcionProducto, p.Precio AS PrecioProducto, p.Categoria AS CategoriaProducto FROM Producto p";
$resultadoProductos = $conexion->query($sqlProductos);

// Consulta SQL para obtener los datos de los pedidos
$sqlPedidos = "SELECT ped.ID AS PedidoID, ped.ClienteID AS ClienteIDPedido, ped.FechaPedido AS FechaPedido, ped.EstadoPedido AS EstadoPedido FROM Pedido ped";
$resultadoPedidos = $conexion->query($sqlPedidos);

// Consulta SQL para obtener los datos de los detalles de los pedidos
$sqlDetallesPedidos = "SELECT dp.PedidoID AS PedidoIDDetalle, dp.ProductoID AS ProductoIDDetalle, dp.Cantidad AS CantidadDetalle, dp.PrecioUnitario AS PrecioUnitarioDetalle FROM DetallePedido dp";
$resultadoDetallesPedidos = $conexion->query($sqlDetallesPedidos);

// Realizar el análisis de ventas
if ($resultadoDetallesPedidos->num_rows > 0) {
    // Inicializar variables para el análisis
    $totalVentas = 0;
    $clientes = [];
    $productos = [];

    // Procesar los datos de los detalles de los pedidos
    while ($fila = $resultadoDetallesPedidos->fetch_assoc()) {
        // Calcular el total de ventas
        $totalVentas += $fila['CantidadDetalle'] * $fila['PrecioUnitarioDetalle'];

        // Aquí podrías realizar otros cálculos o análisis según tus necesidades

        // Por ejemplo, podrías contar la cantidad de clientes y productos
        // y almacenarlos en un array asociativo para su posterior uso
    }

    // Generar el texto de análisis
    echo "Análisis de Ventas:\n";
    echo "Total de Ventas: S/" . number_format($totalVentas, 2) . "\n";
    // Aquí podrías mostrar otros resultados de tu análisis

} else {
    echo "No hay datos disponibles para analizar.";
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>

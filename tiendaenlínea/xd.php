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

drop DATABASE tiendaenlínea;

CREATE DATABASE tiendaenlínea;

USE tiendaenlínea;

-- Creación de la tabla Cliente
CREATE TABLE Cliente (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(50),
    Apellido VARCHAR(50),
    CorreoElectronico VARCHAR(100),
    Direccion VARCHAR(255),
    Ciudad VARCHAR(100),
    Pais VARCHAR(100),
    Telefono VARCHAR(20)
);

-- Creación de la tabla Producto
CREATE TABLE Producto (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100),
    Descripcion TEXT,
    Precio DECIMAL(10, 2),
    Categoria VARCHAR(100)
);

-- Creación de la tabla Pedido
CREATE TABLE Pedido (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    ClienteID INT,
    FechaPedido DATE,
    EstadoPedido VARCHAR(50),
    FOREIGN KEY (ClienteID) REFERENCES Cliente(ID)
);

-- Creación de la tabla DetallePedido
CREATE TABLE DetallePedido (
    PedidoID INT,
    ProductoID INT,
    Cantidad INT,
    PrecioUnitario DECIMAL(10, 2),
    PRIMARY KEY (PedidoID, ProductoID),
    FOREIGN KEY (PedidoID) REFERENCES Pedido(ID),
    FOREIGN KEY (ProductoID) REFERENCES Producto(ID)
);

-- Datos para la tabla Cliente
INSERT INTO Cliente (Nombre, Apellido, CorreoElectronico, Direccion, Ciudad, Pais, Telefono) VALUES
('Juan', 'Perez', 'juan@example.com', 'Calle 123', 'Ciudad de México', 'México', '+52 1234567890'),
('María', 'García', 'maria@example.com', 'Avenida 456', 'Madrid', 'España', '+34 987654321'),
('John', 'Doe', 'john@example.com', '123 Main Street', 'New York', 'USA', '+1 555-123-4567');

-- Datos para la tabla Producto
INSERT INTO Producto (Nombre, Descripcion, Precio, Categoria) VALUES
('Camisa', 'Camisa de algodón de alta calidad', 25.99, 'Ropa'),
('Pantalón', 'Pantalón de mezclilla azul', 35.50, 'Ropa'),
('Zapatos', 'Zapatos de cuero negros', 49.99, 'Calzado'),
('Gorra', 'Gorra con visera ajustable', 15.00, 'Accesorios');

-- Datos para la tabla Pedido
INSERT INTO Pedido (ClienteID, FechaPedido, EstadoPedido) VALUES
(1, '2024-02-24', 'Pendiente'),
(2, '2024-02-23', 'Completado'),
(3, '2024-02-22', 'Enviado');

-- Datos para la tabla DetallePedido
INSERT INTO DetallePedido (PedidoID, ProductoID, Cantidad, PrecioUnitario) VALUES
(1, 1, 2, 25.99),
(1, 3, 1, 49.99),
(2, 2, 1, 35.50),
(3, 4, 3, 15.00);

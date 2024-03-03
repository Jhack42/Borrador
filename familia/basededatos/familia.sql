drop DATABASE familia;

CREATE DATABASE familia;

USE familia;

-- Crear la tabla de personas
CREATE TABLE persona (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    correo VARCHAR(255) NOT NULL
);

-- Crear la tabla de habilidades
CREATE TABLE habilidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    persona_id INT,
    habilidad VARCHAR(255) NOT NULL,
    FOREIGN KEY (persona_id) REFERENCES persona(id)
);

-- Crear la tabla de hijos
CREATE TABLE hijos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    persona_id INT,
    hijo_nombre VARCHAR(255) NOT NULL,
    FOREIGN KEY (persona_id) REFERENCES persona(id)
);


INSERT INTO persona (nombre, correo) VALUES
('Juan Pérez', 'juan@example.com'),
('María López', 'maria@example.com'),
('Carlos García', 'carlos@example.com'),
('Laura Martínez', 'laura@example.com'),
('Ana Rodríguez', 'ana@example.com'),
('Pedro Sánchez', 'pedro@example.com'),
('Sofía Ramírez', 'sofia@example.com'),
('Luis Hernández', 'luis@example.com'),
('Elena Gómez', 'elena@example.com'),
('Diego Fernández', 'diego@example.com');


INSERT INTO habilidades (persona_id, habilidad) VALUES
(1, 'Programación'),
(2, 'Diseño gráfico'),
(3, 'Marketing'),
(4, 'Redacción'),
(5, 'Gestión de proyectos'),
(6, 'Desarrollo web'),
(7, 'Ingeniería'),
(8, 'Contabilidad'),
(9, 'Recursos humanos'),
(10, 'Ventas');

INSERT INTO hijos (persona_id, hijo_nombre) VALUES
(1, 'Pedro Pérez'),
(2, 'Ana López'),
(3, 'Juan García'),
(4, 'Lucía Martínez'),
(5, 'Diego Rodríguez'),
(6, 'María Sánchez'),
(7, 'Carlos Ramírez'),
(8, 'Sara Hernández'),
(9, 'Laura Gómez'),
(10, 'Daniel Fernández');



-- ----------------------------------------------------------------------
-- Crear la tabla de personas
CREATE TABLE persona (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    correo VARCHAR(255) NOT NULL,
	fecha DATE NOT NULL,
    hora TIME NOT NULL
);

-- Crear la tabla de habilidades
CREATE TABLE habilidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    persona_id INT,
    habilidad VARCHAR(255) NOT NULL,
    FOREIGN KEY (persona_id) REFERENCES persona(id)
);

-- Crear la tabla de hijos
CREATE TABLE hijos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    persona_id INT,
    hijo_nombre VARCHAR(255) NOT NULL,
    FOREIGN KEY (persona_id) REFERENCES persona(id)
);


INSERT INTO persona (nombre, correo, fecha, hora) VALUES
('Juan Pérez', 'juan@example.com', '2023-01-15', '08:30:00'),
('María López', 'maria@example.com', '2023-02-20', '09:45:00'),
('Carlos García', 'carlos@example.com', '2023-03-10', '10:15:00'),
('Laura Martínez', 'laura@example.com', '2023-04-05', '11:00:00'),
('Ana Rodríguez', 'ana@example.com', '2023-05-12', '14:20:00'),
('Pedro Sánchez', 'pedro@example.com', '2023-06-18', '15:30:00'),
('Sofía Ramírez', 'sofia@example.com', '2023-07-22', '16:45:00'),
('Luis Hernández', 'luis@example.com', '2023-08-09', '17:00:00'),
('Elena Gómez', 'elena@example.com', '2023-09-30', '18:10:00'),
('Diego Fernández', 'diego@example.com', '2023-10-25', '19:20:00');


INSERT INTO habilidades (persona_id, habilidad) VALUES
(1, 'Programación'),
(2, 'Diseño gráfico'),
(3, 'Marketing'),
(4, 'Redacción'),
(5, 'Gestión de proyectos'),
(6, 'Desarrollo web'),
(7, 'Ingeniería'),
(8, 'Contabilidad'),
(9, 'Recursos humanos'),
(10, 'Ventas');

INSERT INTO hijos (persona_id, hijo_nombre) VALUES
(1, 'Pedro Pérez'),
(2, 'Ana López'),
(3, 'Juan García'),
(4, 'Lucía Martínez'),
(5, 'Diego Rodríguez'),
(6, 'María Sánchez'),
(7, 'Carlos Ramírez'),
(8, 'Sara Hernández'),
(9, 'Laura Gómez'),
(10, 'Daniel Fernández');


--  -------------------------------------------------------------------
ALTER TABLE persona
ADD direccion_imagen VARCHAR(255) NOT NULL;


CREATE TABLE persona (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    correo VARCHAR(255) NOT NULL,
	fecha DATE NOT NULL,
    hora TIME NOT NULL,
    direccion_imagen VARCHAR(255) NOT NULL,
);
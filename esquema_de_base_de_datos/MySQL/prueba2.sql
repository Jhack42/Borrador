CREATE DATABASE IF NOT EXISTS prueba2;
USE prueba2;


-- Eliminar la base de datos existente si es necesario
DROP DATABASE IF EXISTS prueba2;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    email VARCHAR(100)
);

CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    descripcion VARCHAR(255),
    cantidad INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);


CREATE TABLE tabla_resultado AS
SELECT pedidos.id, usuarios.nombre AS nombre_usuario, pedidos.descripcion, pedidos.cantidad
FROM pedidos
JOIN usuarios ON pedidos.id_usuario = usuarios.id;

INSERT INTO usuarios (nombre, email) VALUES ('Juan', 'juan@example.com');
INSERT INTO pedidos (id_usuario, descripcion, cantidad) VALUES (1, 'Producto A', 2);



SELECT * FROM tabla_resultado;
SELECT * FROM usuarios;
SELECT * FROM pedidos;



-- Creación de la tabla para estudiantes
CREATE TABLE estudiantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    fecha_nacimiento DATE,
    direccion VARCHAR(255),
    telefono VARCHAR(20)
);

-- Creación de la tabla para maestros
CREATE TABLE maestros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    fecha_nacimiento DATE,
    direccion VARCHAR(255),
    telefono VARCHAR(20),
    especialidad VARCHAR(100)
);

-- Creación de la tabla para cursos
CREATE TABLE cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    descripcion TEXT,
    maestro_id INT,
    FOREIGN KEY (maestro_id) REFERENCES maestros(id)
);

-- Creación de la tabla para inscripciones
CREATE TABLE inscripciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    estudiante_id INT,
    curso_id INT,
    fecha_inscripcion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id),
    FOREIGN KEY (curso_id) REFERENCES cursos(id)
);


-- Datos de ejemplo para la tabla de estudiantes
INSERT INTO estudiantes (nombre, apellido, fecha_nacimiento, direccion, telefono)
VALUES ('Juan', 'Pérez', '2000-05-15', 'Calle 123', '123456789'),
       ('María', 'González', '1999-09-20', 'Avenida 456', '987654321');

-- Datos de ejemplo para la tabla de maestros
INSERT INTO maestros (nombre, apellido, fecha_nacimiento, direccion, telefono, especialidad)
VALUES ('Carlos', 'Martínez', '1985-03-10', 'Avenida Principal', '555123456', 'Matemáticas'),
       ('Laura', 'López', '1978-07-25', 'Calle Secundaria', '555987654', 'Historia');

-- Datos de ejemplo para la tabla de cursos
INSERT INTO cursos (nombre, descripcion, maestro_id)
VALUES ('Matemáticas Básicas', 'Curso introductorio a las matemáticas', 1),
       ('Historia del Arte', 'Exploración de las obras de arte más importantes', 2);

-- Datos de ejemplo para la tabla de inscripciones
INSERT INTO inscripciones (estudiante_id, curso_id)
VALUES (1, 1),
       (2, 2),
       (1, 2);












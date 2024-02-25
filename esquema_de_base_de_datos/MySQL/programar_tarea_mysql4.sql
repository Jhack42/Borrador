-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS programar_tarea_mysql4;
USE programar_tarea_mysql4;

-- Eliminar la base de datos existente si es necesario
DROP DATABASE IF EXISTS programar_tarea_mysql4;

-- Crear la tabla de tareas programadas
CREATE TABLE tareas_programadas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    correo VARCHAR(255)
);

-- Insertar algunas tareas programadas de ejemplo
INSERT INTO tareas_programadas (fecha, hora, correo) VALUES
('2024-02-08', '15:28:00', 'cacereshilasacajhack@gmail.com'),
('2024-02-08', '15:29:00', 'cacereshilasacajhack@gmail.com'),
('2024-02-08', '15:30:00', 'cacereshilasacajhack@gmail.com');





-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS programar_tarea_mysql5;
USE programar_tarea_mysql5;

-- Eliminar la base de datos existente si es necesario
DROP DATABASE IF EXISTS programar_tarea_mysql5;


CREATE TABLE tareas_programadas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    nombres VARCHAR(255) NOT NULL,
    apellidos VARCHAR(255) NOT NULL,
    dni VARCHAR(20) NOT NULL,
    carrera VARCHAR(100) NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    correo VARCHAR(255) NOT NULL
);
INSERT INTO tareas_programadas (fecha, hora, nombres, apellidos, dni, carrera, correo) VALUES
('2024-02-08', '22:16:00', 'Juan', 'Pérez', '12345678A', 'Ingeniería Informática', 'cacereshilasacajhack@gmail.com'),
('2024-02-11', '09:30:00', 'María', 'González', '98765432B', 'Matemáticas', 'cacereshilasacajhack@gmail.com'),
('2024-02-12', '10:45:00', 'Carlos', 'Martínez', '56789012C', 'Medicina', 'cacereshilasacajhack@gmail.com'),
('2024-02-13', '14:15:00', 'Ana', 'López', '34567890D', 'Derecho', 'cacereshilasacajhack@gmail.com'),
('2024-02-14', '15:30:00', 'Luis', 'Sánchez', '90123456E', 'Administración de Empresas', 'cacereshilasacajhack@gmail.com');


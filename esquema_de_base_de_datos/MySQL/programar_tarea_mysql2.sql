CREATE DATABASE programar_tarea_mysql2;

USE programar_tarea_mysql2;
drop database programar_tarea_mysql;

CREATE TABLE tareas_programadas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

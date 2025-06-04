-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS proyectos_db;
USE proyectos_db;

-- Crear la tabla de proyectos
CREATE TABLE IF NOT EXISTS proyectos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    imagen VARCHAR(255),
    url_github VARCHAR(255),
    url_produccion VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 
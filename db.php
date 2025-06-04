<?php
$servername = "localhost";
$username = "root";
$password = "";

// Primero crear conexión sin seleccionar base de datos
$conn = new mysqli($servername, $username, $password);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Crear la base de datos si no existe
$sql = "CREATE DATABASE IF NOT EXISTS proyectos_db";
if ($conn->query($sql) === TRUE) {
    // Seleccionar la base de datos
    $conn->select_db("proyectos_db");
    
    // Crear la tabla si no existe
    $sql = "CREATE TABLE IF NOT EXISTS proyectos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titulo VARCHAR(255) NOT NULL,
        descripcion TEXT,
        imagen VARCHAR(255),
        url_github VARCHAR(255),
        url_produccion VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if (!$conn->query($sql)) {
        die("Error creando la tabla: " . $conn->error);
    }
} else {
    die("Error creando la base de datos: " . $conn->error);
}

// Establecer charset a utf8
$conn->set_charset("utf8");
?>
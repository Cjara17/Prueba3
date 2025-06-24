<?php
$servername = "localhost";
$username = "catalina_salas";
$password = "catalina_salas2025";
$dbname = "catalina_salas_db1";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}
?>
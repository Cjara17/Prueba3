<?php
// Inicia la sesión
session_start();
// Incluye la conexión a la base de datos
include 'db.php';

// Mostrar errores para depuración (solo en desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$error = '';
// Si el formulario fue enviado por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username']; // Usuario ingresado
  $password = md5($_POST['password']); // Contraseña encriptada con md5

  // Consulta para buscar el usuario y la contraseña
  $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = $conn->query($sql);

  if ($result->num_rows === 1) { // Si existe el usuario
    $_SESSION['user'] = $username; // Guarda el usuario en sesión
    header("Location: index.php"); // Redirige al inicio
    exit();
  } else {
    $error = "Credenciales incorrectas."; // Mensaje de error
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <?php if($error): ?>
      <div class="login-error"><?= $error ?></div>
    <?php endif; ?>
    <form method="post" class="login-form">
      <div style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem; width: 100%;">
        <!-- Campo de usuario -->
        <label for="username" style="font-weight:600; width: 90px; text-align: center;">Usuario</label>
        <input type="text" id="username" name="username" placeholder="Usuario" required autofocus style="width: 90px; min-width: 60px; max-width: 90px; padding: 0.3rem; font-size: 0.85rem; margin-bottom: 0.5rem;">
        <!-- Campo de contraseña -->
        <label for="password" style="font-weight:600; width: 90px; text-align: center;">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Contraseña" required style="width: 90px; min-width: 60px; max-width: 90px; padding: 0.3rem; font-size: 0.85rem; margin-bottom: 0.5rem;">
        <!-- Botón de enviar -->
        <button type="submit" style="margin-top: 0.7rem; width: 100px;">Inicar Sesion</button>
      </div>
    </form>
  </div>
</body>
</html>
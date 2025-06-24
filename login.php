<?php
session_start();
include 'db.php';

// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = md5($_POST['password']);

  $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = $conn->query($sql);

  if ($result->num_rows === 1) {
    $_SESSION['user'] = $username;
    header("Location: index.php");
    exit();
  } else {
    $error = "Credenciales incorrectas.";
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
        <label for="username" style="font-weight:600; width: 90px; text-align: center;">Usuario</label>
        <input type="text" id="username" name="username" placeholder="Usuario" required autofocus style="width: 90px; min-width: 60px; max-width: 90px; padding: 0.3rem; font-size: 0.85rem; margin-bottom: 0.5rem;">
        <label for="password" style="font-weight:600; width: 90px; text-align: center;">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Contraseña" required style="width: 90px; min-width: 60px; max-width: 90px; padding: 0.3rem; font-size: 0.85rem; margin-bottom: 0.5rem;">
        <button type="submit" style="margin-top: 0.7rem; width: 100px;">Inicar Sesion</button>
      </div>
    </form>
  </div>
</body>
</html>
<?php
// Incluye la autenticación de usuario
include 'auth.php';
// Incluye la conexión a la base de datos
include 'db.php';

// Obtiene el ID del proyecto a editar desde la URL
$id = $_GET['id'];
// Consulta los datos actuales del proyecto
$proyecto = $conn->query("SELECT * FROM proyectos WHERE id=$id")->fetch_assoc();

$upload_error = '';
// Si el formulario fue enviado por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Obtiene los datos del formulario
  $titulo = $_POST['titulo'];
  $descripcion = $_POST['descripcion'];
  $url_github = $_POST['url_github'];
  $url_produccion = $_POST['url_produccion'];

  $img_sql = "";
  // Si se subió una nueva imagen y no hubo error
  if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
    $allowed = ['jpg', 'jpeg', 'png', 'gif']; // Tipos permitidos
    $filename = $_FILES['imagen']['name']; // Nombre original
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION)); // Extensión
    if (in_array($ext, $allowed)) { // Si la extensión es válida
      $new_filename = uniqid() . '.' . $ext; // Nombre único
      $upload_path = 'uploads/' . $new_filename; // Ruta destino
      if (move_uploaded_file($_FILES['imagen']['tmp_name'], $upload_path)) { // Mueve el archivo
        $img_sql = ", imagen='$new_filename'"; // Prepara la actualización de la imagen
      } else {
        $upload_error = 'Error al mover la imagen. Verifica permisos de la carpeta uploads.';
      }
    } else {
      $upload_error = 'Tipo de archivo no permitido. Usa jpg, jpeg, png o gif.';
    }
  }

  // Prepara y ejecuta la consulta de actualización
  $sql = "UPDATE proyectos SET titulo='$titulo', descripcion='$descripcion', url_github='$url_github', url_produccion='$url_produccion' $img_sql WHERE id=$id";
  $conn->query($sql);
  // Si no hubo error de imagen, redirige al index
  if ($upload_error === '') {
    header("Location: index.php");
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Proyecto | Portafolio Catalina Salas</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <div class="edit-form-container">
    <h2>Editar Proyecto</h2>
    <?php if (!empty($upload_error)): ?>
      <div class="error"><?= $upload_error ?></div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data">
      <label for="titulo">Título</label>
      <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($proyecto['titulo']) ?>" required>

      <label for="descripcion">Descripción</label>
      <textarea id="descripcion" name="descripcion" rows="4" required><?= htmlspecialchars($proyecto['descripcion']) ?></textarea>

      <label for="url_github">URL GitHub</label>
      <input type="url" id="url_github" name="url_github" value="<?= htmlspecialchars($proyecto['url_github']) ?>">

      <label for="url_produccion">URL Producción</label>
      <input type="url" id="url_produccion" name="url_produccion" value="<?= htmlspecialchars($proyecto['url_produccion']) ?>">

      <label for="imagen">Imagen (opcional)</label>
      <input type="file" id="imagen" name="imagen">
      <?php if($proyecto['imagen']): ?>
        <img src="uploads/<?= htmlspecialchars($proyecto['imagen']) ?>" alt="Imagen actual" class="current-img">
      <?php endif; ?>

      <button type="submit">Actualizar Proyecto</button>
    </form>
  </div>
</body>
</html>

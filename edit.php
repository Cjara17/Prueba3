<?php
include 'auth.php';
include 'db.php';

$id = $_GET['id'];
$proyecto = $conn->query("SELECT * FROM proyectos WHERE id=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $titulo = $_POST['titulo'];
  $descripcion = $_POST['descripcion'];
  $url_github = $_POST['url_github'];
  $url_produccion = $_POST['url_produccion'];

  if ($_FILES['imagen']['name']) {
    $imagen = $_FILES['imagen']['name'];
    move_uploaded_file($_FILES['imagen']['tmp_name'], "uploads/$imagen");
    $img_sql = ", imagen='$imagen'";
  } else {
    $img_sql = "";
  }

  $sql = "UPDATE proyectos SET titulo='$titulo', descripcion='$descripcion', url_github='$url_github', url_produccion='$url_produccion' $img_sql WHERE id=$id";
  $conn->query($sql);
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Proyecto | Portafolio Catalina Salas</title>
  <link rel="stylesheet" href="css/styles.css">
  <style>
    .edit-form-container {
      max-width: 500px;
      margin: 2rem auto;
      background: #fff;
      border-radius: 1rem;
      box-shadow: 0 4px 16px rgba(107,70,193,0.10);
      padding: 2rem 2.5rem;
    }
    .edit-form-container h2 {
      text-align: center;
      color: var(--primary-purple);
      margin-bottom: 2rem;
    }
    .edit-form-container label {
      font-weight: 600;
      color: var(--primary-pink);
      display: block;
      margin-bottom: 0.3rem;
      margin-top: 1rem;
    }
    .edit-form-container input[type="text"],
    .edit-form-container input[type="url"],
    .edit-form-container textarea {
      width: 100%;
      padding: 0.7rem;
      border: 1px solid #ddd;
      border-radius: 0.5rem;
      margin-bottom: 0.5rem;
      font-size: 1rem;
      background: #faf5ff;
      resize: vertical;
    }
    .edit-form-container input[type="file"] {
      margin-top: 0.5rem;
      margin-bottom: 1rem;
    }
    .edit-form-container button {
      background: var(--primary-purple);
      color: #fff;
      border: none;
      padding: 0.8rem 2rem;
      border-radius: 0.5rem;
      font-size: 1.1rem;
      font-weight: 700;
      cursor: pointer;
      margin-top: 1rem;
      width: 100%;
      transition: background 0.2s;
    }
    .edit-form-container button:hover {
      background: var(--primary-pink);
    }
    .edit-form-container .current-img {
      display: block;
      margin: 1rem auto;
      max-width: 100%;
      border-radius: 0.5rem;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
  </style>
</head>
<body>
  <div class="edit-form-container">
    <h2>Editar Proyecto</h2>
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

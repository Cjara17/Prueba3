<?php
// Incluye la autenticación de usuario
include 'auth.php';
// Incluye la conexión a la base de datos
include 'db.php';

// Si el formulario fue enviado por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtiene los datos del formulario
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $url_github = $_POST['url_github'];
    $url_produccion = $_POST['url_produccion'];
    
    // Manejo de la imagen
    $imagen = '';
    $upload_error = '';
    // Si se subió una imagen y no hubo error
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif']; // Tipos permitidos
        $filename = $_FILES['imagen']['name']; // Nombre original
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION)); // Extensión
        if (in_array($ext, $allowed)) { // Si la extensión es válida
            $new_filename = uniqid() . '.' . $ext; // Nombre único
            $upload_path = 'uploads/' . $new_filename; // Ruta destino
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $upload_path)) { // Mueve el archivo
                $imagen = $new_filename; // Guarda el nombre en la BD
            } else {
                $upload_error = 'Error al mover la imagen. Verifica permisos de la carpeta uploads.';
            }
        } else {
            $upload_error = 'Tipo de archivo no permitido. Usa jpg, jpeg, png o gif.';
        }
    } elseif (isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== 4) {
        // Si hubo otro error al subir la imagen
        $upload_error = 'Error al subir la imagen. Código: ' . $_FILES['imagen']['error'];
    }
    
    // Prepara la consulta para insertar el proyecto
    $sql = "INSERT INTO proyectos (titulo, descripcion, imagen, url_github, url_produccion) 
            VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql); // Prepara la consulta
    $stmt->bind_param("sssss", $titulo, $descripcion, $imagen, $url_github, $url_produccion); // Asocia los valores
    
    // Ejecuta la consulta y redirige si fue exitosa
    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        $error = "Error al agregar el proyecto: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Proyecto</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="nav-links">
        <a href="index.php">← Volver a Proyectos</a>
    </div>
    
    <div class="form-container">
        <h2>Agregar Nuevo Proyecto</h2>
        
        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <?php if (!empty($upload_error)): ?>
            <div class="error"><?= $upload_error ?></div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo">Título del Proyecto</label>
                <input type="text" id="titulo" name="titulo" required>
            </div>
            
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="imagen">Imagen del Proyecto</label>
                <input type="file" id="imagen" name="imagen" accept="image/*">
            </div>
            
            <div class="form-group">
                <label for="url_github">URL de GitHub</label>
                <input type="url" id="url_github" name="url_github" required>
            </div>
            
            <div class="form-group">
                <label for="url_produccion">URL de Producción</label>
                <input type="url" id="url_produccion" name="url_produccion" required>
            </div>
            
            <button type="submit" class="btn-submit">Agregar Proyecto</button>
        </form>
    </div>
</body>
</html>
<?php
include 'auth.php';
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $url_github = $_POST['url_github'];
    $url_produccion = $_POST['url_produccion'];
    
    // Manejo de la imagen
    $imagen = '';
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['imagen']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $new_filename = uniqid() . '.' . $ext;
            $upload_path = 'uploads/' . $new_filename;
            
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $upload_path)) {
                $imagen = $new_filename;
            }
        }
    }
    
    $sql = "INSERT INTO proyectos (titulo, descripcion, imagen, url_github, url_produccion) 
            VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $titulo, $descripcion, $imagen, $url_github, $url_produccion);
    
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
    <style>
        .form-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--primary-purple);
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="url"],
        textarea {
            width: 100%;
            padding: 0.5rem;
            border: 2px solid var(--light-purple);
            border-radius: 0.5rem;
            font-size: 1rem;
        }
        
        textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .btn-submit {
            background-color: var(--primary-purple);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }
        
        .btn-submit:hover {
            background-color: var(--light-purple);
        }
        
        .error {
            color: #e53e3e;
            margin-bottom: 1rem;
        }
    </style>
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
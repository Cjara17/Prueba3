<?php
include 'auth.php';
include 'db.php';
$result = $conn->query("SELECT * FROM proyectos ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Proyectos</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="nav-links">
        <a href="add.php">+ Agregar Proyecto</a> | <a href="logout.php">Cerrar sesión</a>
    </div>
    <h2>Proyectos</h2>
    <div class="projects-grid">
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="project-card">
                <h3><?= $row['titulo'] ?></h3>
                <p><?= $row['descripcion'] ?></p>
                <?php if($row['imagen']): ?>
                    <img src="uploads/<?= $row['imagen'] ?>" alt="<?= $row['titulo'] ?>">
                <?php endif; ?>
                <div class="project-links">
                    <a href="<?= $row['url_github'] ?>" target="_blank">GitHub</a>
                    <a href="<?= $row['url_produccion'] ?>" target="_blank">Enlace</a>
                    <a href="edit.php?id=<?= $row['id'] ?>">Editar</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('¿Seguro?')">Eliminar</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
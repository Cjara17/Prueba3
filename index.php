<?php
// Redirige automáticamente a la vista pública si el usuario no está autenticado
session_start();
// Eliminado el redireccionamiento automático para permitir acceso directo
// if (!isset($_SESSION['user'])) {
//     header("Location: public.php");
//     exit;
// }
// Incluye la autenticación de usuario solo si es necesario
if (isset($_SESSION['user'])) {
    include 'auth.php';
}
// Incluye la conexión a la base de datos
include 'db.php';
// Consulta todos los proyectos ordenados por fecha de creación descendente
$result = $conn->query("SELECT * FROM proyectos ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portafolio Catalina Salas</title>
    <!-- Enlace al archivo de estilos CSS -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1 style="text-align:center; color:var(--primary-purple); margin-top:1rem;">Portafolio Catalina Salas</h1>
    <!-- Barra de navegación -->
    <div class="nav-links">
        <a href="add.php">+ Agregar Proyecto</a> | <a href="logout.php">Cerrar sesión</a>
    </div>
    <h2>Proyectos</h2>
    <!-- Grid de proyectos -->
    <div class="projects-grid">
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="project-card">
                <h3><?= $row['titulo'] ?></h3>
                <p><?= $row['descripcion'] ?></p>
                <?php if($row['imagen']): ?>
                    <!-- Imagen del proyecto -->
                    <img src="uploads/<?= $row['imagen'] ?>" alt="<?= $row['titulo'] ?>" style="width:100%;height:auto;max-height:none;object-fit:contain;">
                <?php endif; ?>
                <div class="project-links">
                    <?php if($row['url_github']): ?>
                        <a href="<?= $row['url_github'] ?>" target="_blank">GitHub</a>
                    <?php endif; ?>
                    <?php if($row['url_produccion']): ?>
                        <a href="<?= $row['url_produccion'] ?>" target="_blank">Enlace</a>
                    <?php endif; ?>
                    <a href="edit.php?id=<?= $row['id'] ?>">Editar</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('¿Seguro?')">Eliminar</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <!-- Modal de contacto -->
    <div id="modal-contacto" class="modal-bg">
      <div class="modal-content">
        <button class="modal-close" id="close-contacto" title="Cerrar">&times;</button>
        <form id="form-contacto" method="post" class="contact-form">
          <div class="form-fields">
            <label for="nombre">Nombre Completo</label>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre completo" required>
            <label for="contacto">Contacto</label>
            <input type="text" id="contacto" name="contacto" placeholder="Teléfono o WhatsApp" required>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" required>
            <label for="mensaje">Mensaje</label>
            <textarea id="mensaje" name="mensaje" placeholder="Tu mensaje" required></textarea>
            <button type="submit">Enviar</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Script para abrir/cerrar el modal de contacto -->
    <script>
      const openBtn = document.getElementById('open-contacto');
      const closeBtn = document.getElementById('close-contacto');
      const modal = document.getElementById('modal-contacto');
      // Abrir modal
      openBtn.addEventListener('click', function(e) {
        e.preventDefault();
        modal.classList.add('active');
      });
      // Cerrar modal
      closeBtn.addEventListener('click', function() {
        modal.classList.remove('active');
      });
      // Cerrar modal al hacer click fuera del contenido
      window.addEventListener('click', function(e) {
        if (e.target === modal) {
          modal.classList.remove('active');
        }
      });
    </script>
</body>
</html>
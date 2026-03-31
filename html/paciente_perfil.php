<?php
include_once("includes-db.php");

// Verificar si se pasa el ID del paciente
if (!isset($_GET['id'])) {
  die("Error: ID de paciente no especificado.");
} 
$paciente_id = intval($_GET['id']);

// Obtener información del paciente
$paciente = $conn->query("SELECT * FROM pacientes WHERE id = $paciente_id")->fetch_assoc();

// Agregar comentario
if (isset($_POST['agregar_comentario'])) {
  $profesional = $conn->real_escape_string($_POST['profesional']);
  $comentario = $conn->real_escape_string($_POST['comentario']);
  $conn->query("INSERT INTO comentarios (paciente_id, profesional, comentario) VALUES ($paciente_id, '$profesional', '$comentario')");
}

// Subir imagen
if (isset($_POST['subir_imagen']) && isset($_FILES['imagen'])) {
  $file = $_FILES['imagen'];
  if ($file['error'] == 0) {
    $nombreArchivo = time() . "_" . basename($file['name']);
    $rutaDestino = "../uploads/" . $nombreArchivo;

    if (move_uploaded_file($file['tmp_name'], $rutaDestino)) {
      $rutaDB = "uploads/" . $nombreArchivo;
      $conn->query("INSERT INTO fotos (paciente_id, ruta) VALUES ($paciente_id, '$rutaDB')");
    }
  }
}

// Obtener comentarios e imágenes
$comentarios = $conn->query("SELECT * FROM comentarios WHERE paciente_id = $paciente_id ORDER BY fecha DESC");
$imagenes = $conn->query("SELECT * FROM fotos WHERE paciente_id = $paciente_id ORDER BY fecha_subida DESC");

// Obtener citas del paciente
$citas = $conn->query("SELECT * FROM citas WHERE paciente_id = $paciente_id ORDER BY fecha DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Perfil del Paciente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f5f8fa; }
    .container { background: white; border-radius: 10px; padding: 20px; margin-top: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    .foto-mini { width: 150px; height: 150px; object-fit: cover; border-radius: 10px; margin: 5px; }
  </style>
</head>
<body>

<div class="container">
  <a href="index.php" class="btn btn-secondary mb-3">← Volver a la lista</a>

  <h2 class="text-center mb-4">Perfil del Paciente</h2>
  <?php if ($paciente): ?>
    <div class="row">
      <div class="col-md-6">
        <h5><strong>Nombre:</strong> <?= htmlspecialchars($paciente['nombre']) ?></h5>
        <p><strong>Cédula:</strong> <?= htmlspecialchars($paciente['cedula']) ?></p>
        <p><strong>Edad:</strong> <?= htmlspecialchars($paciente['edad']) ?></p>
      </div>
      <div class="col-md-6">
        <p><strong>Teléfono:</strong> <?= htmlspecialchars($paciente['telefono']) ?></p>
        <p><strong>Correo:</strong> <?= htmlspecialchars($paciente['correo']) ?></p>
        <p><strong>Dirección:</strong> <?= htmlspecialchars($paciente['direccion']) ?></p>
      </div>
    </div>
  <?php else: ?>
    <div class="alert alert-danger">Paciente no encontrado.</div>
  <?php endif; ?>

  <hr>

  <h4>Comentarios del Profesional</h4>
  <form method="post" class="mb-3">
    <div class="row">
      <div class="col-md-4">
        <input type="text" name="profesional" class="form-control" placeholder="Nombre del profesional" required>
      </div>
      <div class="col-md-6">
        <textarea name="comentario" class="form-control" placeholder="Comentario..." required></textarea>
      </div>
      <div class="col-md-2">
        <button type="submit" name="agregar_comentario" class="btn btn-primary w-100">Agregar</button>
      </div>
    </div>
  </form>

  <?php while ($c = $comentarios->fetch_assoc()): ?>
    <div class="card mb-2">
      <div class="card-body">
        <p><?= nl2br(htmlspecialchars($c['comentario'])) ?></p>
        <small class="text-muted">
          <?= htmlspecialchars($c['profesional']) ?> — <?= $c['fecha'] ?>
        </small>
      </div>
    </div>
  <?php endwhile; ?>

  <hr>

  <h4>Historial de Citas</h4>
  <?php if ($citas->num_rows > 0): ?>
    <table class="table table-bordered">
      <thead class="table-secondary">
        <tr>
          <th>Fecha</th>
          <th>Hora</th>
          <th>Motivo</th>
          <th>Estado</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($cita = $citas->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($cita['fecha']) ?></td>
          <td><?= htmlspecialchars($cita['hora']) ?></td>
          <td><?= htmlspecialchars($cita['motivo']) ?></td>
          <td><?= htmlspecialchars($cita['estado']) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p class="text-muted">No hay citas registradas.</p>
  <?php endif; ?>

  <hr>

  <h4>Imágenes del Paciente</h4>
  <form method="post" enctype="multipart/form-data" class="mb-3">
    <div class="row">
      <div class="col-md-8">
        <input type="file" name="imagen" class="form-control" required>
      </div>
      <div class="col-md-4">
        <button type="submit" name="subir_imagen" class="btn btn-success w-100">Subir Imagen</button>
      </div>
    </div>
  </form>

  <div class="d-flex flex-wrap">
    <?php while ($img = $imagenes->fetch_assoc()): ?>
      <div class="text-center me-2 mb-2">
        <img src="../<?= htmlspecialchars($img['ruta']) ?>" class="foto-mini">
        <p class="small text-muted"><?= $img['fecha_subida'] ?></p>
      </div>
    <?php endwhile; ?>
  </div>

</div>

</body>
</html>

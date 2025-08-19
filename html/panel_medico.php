<?php
session_start();

// Si no hay sesión o el rol no es medico, redirige a login
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== "medico") {
    header("Location: inicio_consultorio.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel del Médico</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #e0f7fa, #ffffff);
    }
    .card-header {
      background: #0288d1;
    }
    .btn-outline-info {
      border-width: 2px;
    }
    .btn-outline-danger {
      border-width: 2px;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="card shadow-lg border-0">
      <div class="card-header text-white text-center">
        <h4 class="mb-0">Panel del Profesional Médico</h4>
      </div>
      <div class="card-body">
        <h5 class="mb-4 text-center text-muted">Bienvenido al Módulo Médico</h5>
        <div class="d-grid gap-3 col-md-6 mx-auto">
          <a href="administrar_horarios.html" class="btn btn-outline-info">Administrar Horarios</a>
          <a href="listar_pacientes.php" class="btn btn-outline-info">Ver Pacientes Registrados</a>
          <a href="comprobantes.html" class="btn btn-outline-info">Emitir Comprobante Médico</a>
          <a href="diagnosticos.html" class="btn btn-outline-info">Gestionar Diagnósticos</a>
          <a href="modificar_medicamentos.html" class="btn btn-outline-info">Modificar Medicamentos</a>
          <a href="perfil_medico.html" class="btn btn-outline-info">Mi Perfil Profesional</a>
          <a href="logout.html" class="btn btn-outline-danger">Cerrar Sesión</a>
        </div>
      </div>
      <div class="card-footer text-muted text-center">
        Sistema Médico © 2025
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Médico</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .horario-dia {
      margin-bottom: 1rem;
    }
    .horario-dia h6 {
      margin-bottom: 0.5rem;
    }
  </style>
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card shadow">
      <div class="card-header bg-primary text-white text-center">
        <h4>Formulario de Registro de Médico</h4>
      </div>
      <form action="guardar_medico.php" method="POST">
        <div class="card-body">
          <!-- Datos personales -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="cedula" class="form-label">Cédula</label>
              <input type="text" class="form-control" name="cedula" required>
            </div>
            <div class="col-md-6">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" name="nombre" required>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="apellido1" class="form-label">Primer Apellido</label>
              <input type="text" class="form-control" name="apellido1" required>
            </div>
            <div class="col-md-6">
              <label for="apellido2" class="form-label">Segundo Apellido</label>
              <input type="text" class="form-control" name="apellido2" required>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="telefono" class="form-label">Teléfono</label>
              <input type="text" class="form-control" name="telefono" required>
            </div>
            <div class="col-md-6">
              <label for="correo" class="form-label">Correo Electrónico</label>
              <input type="email" class="form-control" name="correo" required>
            </div>
          </div>

          <!-- Especialidad -->
          <div class="mb-3">
            <label for="especialidad" class="form-label">Especialidad</label>
            <select class="form-select" name="especialidad" required>
              <option value="">Selecciona una especialidad...</option>
              <option value="Medicina General">Medicina General</option>
              <option value="Cardiología">Cardiología</option>
              <option value="Pediatría">Pediatría</option>
              <option value="Dermatología">Dermatología</option>
              </select>
          </div>

          <!-- Horarios -->
<div class="mb-4">
  <label class="form-label">Disponibilidad por día y hora</label>
  <div class="alert alert-info">
    <strong>ℹ️ Este médico tendrá disponibilidad automática:</strong><br>
    <ul class="mb-0">
      <li>Días: <strong>Lunes a Sábado</strong></li>
      <li>Horas: <strong>08:00 a 18:00</strong> (cada hora)</li>
    </ul>
    No es necesario seleccionar horarios manualmente.
  </div>
</div>

        </div>

        <!-- Botones -->
        <div class="card-footer text-center">
          <button type="submit" class="btn btn-success">Registrar Médico</button>
          <a href="panel_administrador.html" class="btn btn-secondary">Volver al Panel</a>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
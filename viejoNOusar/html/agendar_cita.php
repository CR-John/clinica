<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agendar Cita</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="card shadow-sm">
    <div class="card-header bg-success text-white text-center">
      <h4>Agendar Nueva Cita</h4>
    </div>

    <div class="card-body">
      <form action="guardar_cita.php" method="POST">

        <!-- Seleccion del paciente -->
        <div class="mb-3">
          <label class="form-label">Paciente</label>
          <select class="form-select" name="paciente_id" required>
            <option value="">Seleccione un paciente...</option>
            <?php
            $conn = new mysqli("localhost","root","","clinica");
            $result = $conn->query("SELECT id, nombre, apellido1 FROM pacientes ORDER BY nombre");
            while($row = $result->fetch_assoc()){
              echo "<option value='".$row['id']."'>".$row['nombre']." ".$row['apellido1']."</option>";
            }
            $conn->close();
            ?>
          </select>
        </div>

        <!-- Seleccion del medico -->
        <div class="mb-3">
          <label class="form-label">Médico</label>
          <select class="form-select" name="medico_id" required>
            <option value="">Seleccione un médico...</option>
            <?php
            $conn = new mysqli("localhost","root","","clinica");
            $result = $conn->query("SELECT id, nombre, apellido1, especialidad FROM medicos ORDER BY nombre");
            while($row = $result->fetch_assoc()){
              echo "<option value='".$row['id']."'>Dr. ".$row['nombre']." ".$row['apellido1']." (".$row['especialidad'].")</option>";
            }
            $conn->close();
            ?>
          </select>
        </div>

        <!-- Fecha y hora -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Fecha</label>
            <input type="date" class="form-control" name="fecha" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Hora</label>
            <input type="time" class="form-control" name="hora" required>
          </div>
        </div>

        

        <!-- Motivo -->
        <div class="mb-3">
          <label class="form-label">Motivo de la cita</label>
          <textarea class="form-control" name="motivo" rows="3"></textarea>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-success">Guardar Cita</button>
        </div>
      </form>
    </div>

    <div class="card-footer text-center">
      <a href="panel_administrador.html" class="btn btn-outline-secondary">Volver al Panel</a>
    </div>
  </div>
</div>

</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de Citas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="card shadow">
    <div class="card-header bg-primary text-white text-center">
      <h4>📅 Citas Programadas</h4>
    </div>
    <div class="card-body">
      <?php
      $conn = new mysqli("localhost","root","","clinica");

      if ($conn->connect_error) {
          die("<div class='alert alert-danger'>❌ Conexión fallida: " . $conn->connect_error . "</div>");
      }
      // Consulta para obtener citas con detalles de paciente y médico
      $sql = "SELECT c.id, p.nombre AS paciente, m.nombre AS medico, m.especialidad, c.fecha, c.hora, c.motivo
              FROM citas c
              JOIN pacientes p ON c.paciente_id = p.id
              JOIN medicos m ON c.medico_id = m.id
              ORDER BY c.fecha, c.hora";

      $result = $conn->query($sql);
      // Mostrar resultados en una tabla
      if ($result->num_rows > 0) {
          echo "<table class='table table-striped table-bordered'>
                  <thead class='table-light'>
                    <tr>
                      <th>ID</th>
                      <th>Paciente</th>
                      <th>Médico</th>
                      <th>Especialidad</th>
                      <th>Fecha</th>
                      <th>Hora</th>
                      <th>Motivo</th>
                    </tr>
                  </thead><tbody>";

          while($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>{$row['id']}</td>
                      <td>{$row['paciente']}</td>
                      <td>{$row['medico']}</td>
                      <td>{$row['especialidad']}</td>
                      <td>{$row['fecha']}</td>
                      <td>{$row['hora']}</td>
                      <td>{$row['motivo']}</td>
                    </tr>";
          }

          echo "</tbody></table>";
      } else {
          echo "<div class='alert alert-warning'>No hay citas registradas.</div>";
      }

      $conn->close();
      ?>
    </div>
    <div class="card-footer text-center">
      <a href="panel_administrador.html" class="btn btn-outline-secondary">Volver al Panel</a>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
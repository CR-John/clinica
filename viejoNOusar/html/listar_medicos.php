<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de Médicos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="card shadow">
    <div class="card-header bg-success text-white text-center">
      <h4>Lista de Médicos Registrados</h4>
    </div>
    <div class="card-body">
      <?php
      $conn = new mysqli("localhost", "root", "", "clinica");
      if ($conn->connect_error) {
          die("<div class='alert alert-danger'>❌ Conexión fallida: " . $conn->connect_error . "</div>");
      }
      // Consulta para obtener medicos y sus horarios especiales
      $sql = "SELECT m.id, m.cedula, m.nombre, m.apellido1, m.apellido2, m.especialidad, m.telefono, m.correo,
                     h.dia_semana, h.hora_inicio, h.hora_fin
              FROM medicos m
              LEFT JOIN horarios_medicos h ON m.id = h.medico_id
              ORDER BY m.nombre, FIELD(h.dia_semana,'Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo')";

      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          $medicos = [];

          while($row = $result->fetch_assoc()) {
              $id = $row['id'];
              if (!isset($medicos[$id])) {
                  $medicos[$id] = [
                      'cedula' => $row['cedula'],
                      'nombre' => $row['nombre'],
                      'apellido1' => $row['apellido1'],
                      'apellido2' => $row['apellido2'],
                      'especialidad' => $row['especialidad'],
                      'telefono' => $row['telefono'],
                      'correo' => $row['correo'],
                      'horarios' => []
                  ];
              }
              if ($row['dia_semana']) {
                  $medicos[$id]['horarios'][] = $row['dia_semana'] . " — " . $row['hora_inicio'];
              }
          }

          echo "<table class='table table-bordered table-hover'>";
          echo "<thead class='table-light'>
                  <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Especialidad</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Horarios Especiales</th>
                  </tr>
                </thead><tbody>";

          foreach($medicos as $medico) {
              echo "<tr>
                      <td>{$medico['cedula']}</td>
                      <td>{$medico['nombre']} {$medico['apellido1']} {$medico['apellido2']}</td>
                      <td>{$medico['especialidad']}</td>
                      <td>{$medico['telefono']}</td>
                      <td>{$medico['correo']}</td>
                      <td>" . implode("<br>", $medico['horarios']) . "</td>
                    </tr>";
          }

          echo "</tbody></table>";
      } else {
          echo "<div class='alert alert-warning'>No hay médicos registrados.</div>";
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

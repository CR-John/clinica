<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de Pacientes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="card shadow">
    <div class="card-header bg-primary text-white text-center">
      <h4>Lista de Pacientes Registrados</h4>
    </div>
    <div class="card-body">
      <?php
      $conn = new mysqli("localhost", "root", "", "clinica");
      if ($conn->connect_error) {
          die("<div class='alert alert-danger'>❌ Conexión fallida: " . $conn->connect_error . "</div>");
      }

      $sql = "SELECT * FROM pacientes ORDER BY nombre";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          echo "<table class='table table-bordered table-hover'>";
          echo "<thead class='table-light'>
                  <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Edad</th>
                    <th>Estado</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Dirección</th>
                  </tr>
                </thead><tbody>";

          while($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>{$row['cedula']}</td>
                      <td>{$row['nombre']} {$row['apellido1']} {$row['apellido2']}</td>
                      <td>{$row['edad']}</td>
                      <td>{$row['estado_paciente']}</td>
                      <td>{$row['telefono']}</td>
                      <td>{$row['correo']}</td>
                      <td>{$row['direccion']}</td>
                    </tr>";
          }

          echo "</tbody></table>";
      } else {
          echo "<div class='alert alert-warning'>No hay pacientes registrados.</div>";
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

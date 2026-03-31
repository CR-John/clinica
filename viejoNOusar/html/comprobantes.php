<?php
// conexion con la base de datos
$conn = new mysqli("localhost", "root", "", "clinica");
if($conn->connect_error) die("Error de conexión: ".$conn->connect_error);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Generar Comprobante Médico</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #e9f5f9;
      font-family: 'Segoe UI', sans-serif;
    }
    .contenedor {
      max-width: 600px;
      margin: 60px auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #0d6efd;
    }
    .btn-success {
      width: 100%;
    }
  </style>
</head>
<body>
  <div class="contenedor">
    <h2><i class="bi bi-file-earmark-medical"></i> Generar Comprobante Médico</h2>
    <form action="comprobante.php" method="GET">
      <label for="cita_id" class="form-label">Selecciona la cita:</label>
      <select name="cita_id" id="cita_id" class="form-select mb-3" required>
        <option value="">-- Elige una cita --</option>
        <?php
        // Traemos las citas con detalles de paciente y medico
        $res = $conn->query("
          SELECT c.id, p.nombre AS paciente, p.apellido1 AS ape1,
                 m.nombre AS medico, m.apellido1 AS mape1,
                 c.fecha, c.hora
          FROM citas c 
          JOIN pacientes p ON c.paciente_id=p.id
          JOIN medicos m ON c.medico_id=m.id
          ORDER BY c.fecha DESC
        ");
        while($row = $res->fetch_assoc()){
          echo "<option value='{$row['id']}'>
                  {$row['fecha']} {$row['hora']} - {$row['paciente']} {$row['ape1']} con Dr. {$row['medico']} {$row['mape1']}
                </option>";
        }
        $conn->close();
        ?>
      </select>
      <button type="submit" class="btn btn-success">
        <i class="bi bi-printer-fill"></i> Generar comprobante
      </button>
      <p>
      <div class="card-footer text-center">
      <a href="panel_administrador.html" class="btn btn-outline-secondary">Volver al Panel</a>
    </div>
    </form>
  </div>
</body>
</html>
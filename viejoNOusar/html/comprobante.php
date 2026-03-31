<?php
// ✅ Evita duplicar sesiones
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Validación de parámetro GET
if (!isset($_GET['cita_id'])) {
    die("❌ No se seleccionó ninguna cita");
}

$cita_id = intval($_GET['cita_id']);

// ✅ Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "clinica");
if ($conn->connect_error) die("Error de conexión: " . $conn->connect_error);

// ✅ Consulta de datos de la cita
$sql = "
SELECT c.id, p.nombre AS paciente, p.apellido1 AS ape1,
       m.nombre AS medico, m.apellido1 AS mape1, m.especialidad,
       c.fecha, c.hora, c.motivo
FROM citas c
JOIN pacientes p ON c.paciente_id = p.id
JOIN medicos m ON c.medico_id = m.id
WHERE c.id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cita_id);
$stmt->execute();
$res = $stmt->get_result();
$cita = $res->fetch_assoc();

if (!$cita) {
    die("❌ La cita no existe");
}

// ✅ Consulta del diagnóstico (si existe)
$diag_sql = "
SELECT diagnostico, tratamiento
FROM diagnosticos
WHERE cita_id = ?
LIMIT 1
";
$stmt_diag = $conn->prepare($diag_sql);
$stmt_diag->bind_param("i", $cita_id);
$stmt_diag->execute();
$res_diag = $stmt_diag->get_result();
$diagnostico = $res_diag->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Comprobante Médico</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; }
    .comprobante {
      max-width: 700px;
      margin: 50px auto;
      padding: 20px;
      background: white;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 { margin-bottom: 20px; }
    .dato { margin-bottom: 10px; }
    .diagnostico-box {
      background-color: #eef6f9;
      padding: 15px;
      border-radius: 6px;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="comprobante">
    <h2 class="text-center">Comprobante de Cita Médica</h2>
    <h2 class="text-center">Consultorio Clínico Pura Vida!</h2>
    <p class="dato"><strong>Paciente:</strong> <?php echo $cita['paciente'] . " " . $cita['ape1']; ?></p>
    <p class="dato"><strong>Médico:</strong> Dr. <?php echo $cita['medico'] . " " . $cita['mape1'] . " (" . $cita['especialidad'] . ")"; ?></p>
    <p class="dato"><strong>Fecha:</strong> <?php echo $cita['fecha']; ?></p>
    <p class="dato"><strong>Hora:</strong> <?php echo $cita['hora']; ?></p>
    <p class="dato"><strong>Motivo de la cita:</strong> <?php echo $cita['motivo']; ?></p>

    <?php if ($diagnostico): ?>
      <div class="diagnostico-box">
        <p class="dato"><strong>Diagnóstico:</strong> <?php echo $diagnostico['diagnostico']; ?></p>
        <p class="dato"><strong>Tratamiento:</strong> <?php echo $diagnostico['tratamiento']; ?></p>
      </div>
    <?php else: ?>
      <p class="dato text-muted"><em>No se ha registrado diagnóstico para esta cita.</em></p>
    <?php endif; ?>

    <hr>
    <p class="text-center">Gracias por confiar en nuestra clínica</p>
    <div class="text-center mt-3">
      <button onclick="window.print()" class="btn btn-primary">Imprimir comprobante</button>
      <?php
      $panel = 'panel_administrador.html';
      if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] == 'medico') {
          $panel = 'panel_medico.php';
      }
      ?>
      <a href="<?php echo $panel; ?>" class="btn btn-secondary">Volver al Panel</a>
    </div>
  </div>
</body>
</html>
<?php $conn->close(); ?>
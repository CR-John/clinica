<?php
$conn = new mysqli("localhost","root","","clinica");
if ($conn->connect_error) { die("Conexión fallida: " . $conn->connect_error); }

// Traemos todos los médicos
$medicos_res = $conn->query("SELECT id, nombre, apellido1, especialidad FROM medicos ORDER BY nombre");
$medicos = [];
while($m = $medicos_res->fetch_assoc()){
    $medicos[$m['id']] = $m['nombre'] . " " . $m['apellido1'] . " (" . $m['especialidad'] . ")";
}

// Obtenemos la semana actual (lunes a viernes)
$semana = [];
for($i=0; $i<5; $i++){
    $dia = date('Y-m-d', strtotime("Monday +$i days"));
    $semana[$dia] = date('D d-m', strtotime($dia));
}

// Traemos todas las citas de la semana
$citas = [];
$fecha_inicio = array_key_first($semana);
$fecha_fin = array_key_last($semana);
$sql = "SELECT c.*, m.nombre, m.apellido1 FROM citas c JOIN medicos m ON c.medico_id=m.id 
        WHERE c.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
$res = $conn->query($sql);
while($row = $res->fetch_assoc()){
    $citas[$row['medico_id']][$row['fecha']][] = $row['hora']." - ".$row['motivo'];
}

// Traemos horarios de médicos
$horarios_medicos = [];
$horarios_res = $conn->query("SELECT * FROM horarios_medicos");
while($h = $horarios_res->fetch_assoc()){
    $horarios_medicos[$h['medico_id']][$h['dia_semana']][] = $h['hora_inicio']."-".$h['hora_fin'];
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Calendario de Médicos</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.table td, .table th { vertical-align: middle; }
.cita { background-color: #d1e7dd; padding: 2px 5px; margin: 2px 0; border-radius: 4px; }
</style>
</head>
<body class="bg-light">
<div class="container mt-5">
  <h3 class="mb-4 text-center">Calendario de Médicos - Semana Actual</h3>
  <table class="table table-bordered table-striped">
    <thead class="table-success text-center">
      <tr>
        <th>Médico</th>
        <?php foreach($semana as $fecha => $label) echo "<th>$label</th>"; ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach($medicos as $id => $nombre): ?>
        <tr>
          <td><?php echo $nombre; ?></td>
          <?php foreach($semana as $fecha => $label): ?>
            <td>
              <?php
              // Día de la semana en inglés para el horario
              $dia_ingles = date('l', strtotime($fecha));
              // Horarios del médico ese día
              if(isset($horarios_medicos[$id][$dia_ingles])){
                  foreach($horarios_medicos[$id][$dia_ingles] as $horario){
                      echo "<div><strong>$horario</strong></div>";
                  }
              }
              // Citas agendadas
              if(isset($citas[$id][$fecha])){
                  foreach($citas[$id][$fecha] as $c){
                      echo "<div class='cita'>$c</div>";
                  }
              }
              
              ?>
            </td>
            
          <?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
    <div class="text-center mt-4">
        <a href="panel_administrador.html" class="btn btn-outline-secondary">Volver al Panel</a>
</div>
</body>
</html>
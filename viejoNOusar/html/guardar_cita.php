<?php
$conn = new mysqli("localhost", "root", "", "clinica");

if ($conn->connect_error) {
    die("<div class='alert alert-danger text-center mt-5'>❌ Error de conexión: " . $conn->connect_error . "</div>");
}

$paciente_id = $_POST['paciente_id'];
$medico_id = $_POST['medico_id'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$motivo = $_POST['motivo'];

$sql = "INSERT INTO citas (paciente_id, medico_id, fecha, hora, motivo)
        VALUES ('$paciente_id', '$medico_id', '$fecha', '$hora', '$motivo')";

echo "<!DOCTYPE html>
<html lang='es'>
<head>
  <meta charset='UTF-8'>
  <title>Cita Guardada</title>
  <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body class='bg-light'>
<div class='container mt-5'>
  <div class='card shadow-sm'>
    <div class='card-body text-center'>";

if ($conn->query($sql) === TRUE) {
    echo "
      <div class='alert alert-success'>
        <h4 class='mb-3'>✅ Cita registrada correctamente</h4>
        <p class='mb-4'>La cita ha sido guardada exitosamente en el sistema.</p>
        <a href='panel_administrador.html' class='btn btn-outline-secondary me-2'>Volver al Panel</a>
        <a href='listar_citas.php' class='btn btn-outline-primary'>Ver todas las citas</a>
      </div>";
} else {
    echo "
      <div class='alert alert-danger'>
        <h4 class='mb-3'>❌ Error al guardar la cita</h4>
        <p>" . $conn->error . "</p>
        <a href='panel_administrador.html' class='btn btn-outline-secondary'>Volver al Panel</a>
      </div>";
}

echo "
    </div>
  </div>
</div>
</body>
</html>";

$conn->close();
?>
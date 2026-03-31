<?php include "includes-auth.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Calendario de Citas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
  <h3 class="text-center mb-4">Calendario de Citas</h3>
  <div id="calendar"></div>
  <div class="text-center mt-4">
    <a href="index.php" class="btn btn-secondary">Volver al Dashboard</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
    initialView: 'dayGridMonth',
    selectable: true,
    editable: true,
    dateClick: function(info) {
      alert('Agregar nueva cita el ' + info.dateStr);
      // luego aqui puedes abrir un modal o redirigir a registrar_cita.php
    }
  });
  calendar.render();
});
</script>
</body>
</html>

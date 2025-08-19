<!DOCTYPE html> 
<html lang="es">

<head>
  <meta charset="UTF-8"> 
    <title>Registrar Médico</title> 
  <meta name="viewport" content="width=device-width, initial-scale=1"> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light"> <!-- Estilo general con fondo claro -->

<div class="container mt-5"> <!-- Contenedor principal con margen superior -->
  <div class="card shadow-sm"> <!-- Tarjeta con sombra para destacar visualmente -->

    <!-- Encabezado del formulario -->
    <div class="card-header bg-info text-white text-center">
      <h4>Registro de Profesional Médico</h4>
    </div>

    <div class="card-body">
      <form id="registroMedico" action="guardar_medico.php" method="POST"> <!-- Formulario principal -->

        <!-- Datos personales -->
        <div class="mb-3">
          <label for="cedula" class="form-label">Cédula</label>
          <input type="text" class="form-control" id="cedula" name="cedula" required>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
          </div>
          <div class="col-md-4">
            <label for="apellido1" class="form-label">Primer Apellido</label>
            <input type="text" class="form-control" id="apellido1" name="apellido1" required>
          </div>
          <div class="col-md-4">
            <label for="apellido2" class="form-label">Segundo Apellido</label>
            <input type="text" class="form-control" id="apellido2" name="apellido2">
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="especialidad" class="form-label">Especialidad Médica</label>
            <select class="form-select" id="especialidad" name="especialidad" required>
              <option value="">Selecciona una especialidad...</option>
              <option value="Medicina General">Medicina General</option>
              <option value="Cardiología">Cardiología</option>
              <option value="Pediatría">Pediatría</option>
              <option value="Dermatología">Dermatología</option>
              <option value="Dermatología">Quiropodia</option>
            </select>
          </div>
          </div>

        <!-- Horario de atención -->
        <div class="row mb-3">
          <h5 class="text-center mt-3">Horario de Atención</h5>

        <?php
        $diasSemana = ["Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"];
        foreach($diasSemana as $dia){
          echo '<div class="row mb-2">
                  <div class="col-md-3">
                    <input type="checkbox" name="dias[]" value="'.$dia.'"> '.$dia.'
                  </div>
                  <div class="col-md-4">
                    <input type="time" name="horaInicio['.$dia.']" class="form-control">
                  </div>
                  <div class="col-md-4">
                    <input type="time" name="horaFin['.$dia.']" class="form-control">
                  </div>
                </div>';
        }
        ?>
          </div>

        <!-- Información de contacto del médico -->
        <hr>
        <h5 class="text-center mb-3">Datos de Contacto</h5>
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="tel" class="form-control" id="telefono" name="telefono">
          </div>
          <div class="col-md-6">
            <label for="correo" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="correo" name="correo">
          </div>
        </div>

        <!-- Botón para enviar el formulario -->
        <div class="d-grid">
          <button type="submit" class="btn btn-info text-white">Guardar Médico</button>
        </div>
      </form>

      <!-- Mensaje de confirmación tras el registro -->
      <div id="mensajeRegistro" class="mt-3 text-center"></div>
    </div>

    <!-- Botón para volver al panel de administrador -->
    <div class="card-footer text-center">
      <a href="panel_administrador.html" class="btn btn-outline-secondary">Volver al Panel</a>
    </div>
  </div>
</div>

  <!-- Carga de Bootstrap JS para funcionalidades interactivas -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
</script>
</body>
</html>

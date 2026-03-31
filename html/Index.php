<?php include_once("includes-db.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clínica de Quiropodia - Michelle Marín Castillo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f9f9f9;
      color: #333;
    }
    header {
      background: linear-gradient(135deg, #00a8b5, #007f8e);
      color: white;
      padding: 20px 20px;
      text-align: center;
    }
    header h1 {
      font-weight: 700;
    }
    .hero {
      background: url("../imagenes/Flyer_MMC.png") no-repeat;
      height: 400px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      text-shadow: 1px 1px 5px rgba(0,0,0,0.6);
    }
    .hero h2 {
      font-size: 2.5rem;
      font-weight: bold;
    }
    .servicios h3 {
      color: #00a8b5;
    }
    footer {
      background-color: #007f8e;
      color: white;
      text-align: center;
      padding: 15px 0;
      margin-top: 40px;
    }
    .btn-custom {
      background-color: #00a8b5;
      color: white;
      border-radius: 25px;
      transition: all 0.3s;
    }
    .btn-custom:hover {
      background-color: #007f8e;
      color: white;
    }
  </style>
</head>
<body>

  <header>
    <h1>MMC Quiropodia</h1>
    <h2> Michelle Marín Castillo </h2>
    <p>Especialista en Quiropodia con amplia carrera nacional e internacional</p>
  </header>

    <section class="text-center my-5">
    <!-- <h3 class="mb-3">Accesos Directos</h3> -->
    <a href="pacientes.php" class="btn btn-custom btn-lg mx-2">Ver Perfiles de Pacientes</a>
    <a href="calendario.php" class="btn btn-custom btn-lg mx-2">Calendario de Citas</a>
  </section>

  <section class="hero">
    <h2> Resultados desde la primera cita — Tratamientos indoloros y efectivos</h2>
  </section>

  <section class="container text-center my-5 servicios">
    <h3 class="mb-4">Tratamientos Especializados</h3>
    <div class="row">
      <div class="col-md-4">
        <h5>Hongos</h5>
        <p>Tratamientos efectivos para infecciones micóticas en uñas y pies.</p>
      </div>
      <div class="col-md-4">
        <h5>Verrugas Plantares</h5>
        <p>Eliminación segura y sin dolor con métodos modernos.</p>
      </div>
      <div class="col-md-4">
        <h5>Uñas Encarnadas</h5>
        <p>Corrección y alivio inmediato con técnicas especializadas.</p>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-md-4">
        <h5>Hiperqueratosis</h5>
        <p>Tratamiento profesional para el exceso de piel endurecida.</p>
      </div>
      <div class="col-md-4">
        <h5>Cuidados Preventivos</h5>
        <p>Asesoría personalizada para el mantenimiento saludable de tus pies.</p>
      </div>
      <div class="col-md-4">
        <h5>Evaluaciones Personalizadas</h5>
        <p>Diagnóstico integral en cada cita con seguimiento continuo.</p>
      </div>
    </div>
  </section>

  <section class="text-center my-5">
    <h3 class="mb-3">Accesos Directos</h3>
    <a href="pacientes/perfil.php" class="btn btn-custom btn-lg mx-2">Ver Perfiles de Pacientes</a>
    <a href="calendario.php" class="btn btn-custom btn-lg mx-2">Calendario de Citas</a>
  </section>

  <footer>
    <p>© <?php echo date('Y'); ?> MMC Quiropodia - Michelle Marín Castillo | Todos los derechos reservados</p>
  </footer>

</body>
</html>

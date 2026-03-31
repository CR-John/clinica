<?php
session_start();
if(isset($_SESSION['error'])){
    echo "<div class='alert alert-danger text-center'>".$_SESSION['error']."</div>";
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="description" content="Ejemplo de HTML5 con Bootstrap">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Consultorio Clínico</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .galeria-collage img {
      width: 100%;
      height: auto;
      margin-bottom: 1rem;
      border-radius: 10px;
    }
    .aside-img {
      width: 100%;
      height: auto;
      border-radius: 10px;
    }
    .map-link {
      text-decoration: none;
      font-weight: bold;
    }
  </style>
</head>
<body class="bg-light">

  <div class="container py-4">

    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 rounded shadow">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Consultorio Clínico Pura Vida</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menuNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="javascript:void(0)" onclick="mostrarSoloQuiropodia()">Quiropodia</a></li>
            <li class="nav-item"><a class="nav-link" href="javascript:void(0)" onclick="mostrarSoloPediatria()">Pediatría</a></li>
            <li class="nav-item"><a class="nav-link" href="javascript:void(0)" onclick="mostrarSoloCardiologia()">Cardiología</a></li>
            <li class="nav-item"><a class="nav-link" href="javascript:void(0)" onclick="mostrarSoloDermatologia()">Dermatología</a></li>
            <li class="nav-item"><a class="nav-link" href="javascript:void(0)" onclick="mostrarSoloMedicina()">Medicina General</a></li>
            <li class="nav-item"><a class="nav-link" href="inicio_consultorio.html">Login</a></li>
          </ul>
        </div>
      </div>
    </nav>

<!-- Mensaje de bienvenida -->
<div id="bienvenida" class="alert alert-info shadow-sm p-4">
  <div class="text-center mb-4">
    <h4>👋 Bienvenido al Consultorio Clínico Pura Vida!</h4>
    <p class="lead">Tu salud y bienestar son nuestra prioridad. Selecciona una especialidad en el menú superior para comenzar.</p>
  </div>

  <div class="row align-items-center">
    <!-- Video para pacientes con sonido desde el inicio -->
<div class="col-md-6 mb-3">
  <div class="ratio ratio-16x9 rounded shadow">
    <iframe width="560" height="315" 
            src="https://www.youtube.com/embed/WjILHS4--o0?autoplay=1" 
            title="Video para pacientes" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen>
    </iframe>
  </div>
</div>

    <!-- Mensaje para pacientes -->
    <div class="col-md-6">
      <h5 class="text-success">🧑‍⚕️ ¿Eres paciente?</h5>
      <p>Explora nuestras especialidades médicas y agenda tu cita con profesionales certificados. Cada sección incluye imágenes, información detallada y contacto directo.</p>
      <ul>
        <li>👶 Atención pediátrica cálida y profesional</li>
        <li>❤️ Chequeos cardiovasculares preventivos</li>
        <li>🧴 Tratamientos dermatológicos estéticos y clínicos</li>
        <li>🩺 Medicina general para toda la familia</li>
      </ul>
      <p class="mt-2">Haz clic en el menú superior para conocer más.</p>
    </div>
  </div>

  <hr class="my-4">

  <div class="row align-items-center">
    <!-- Imagen para médicos -->
    <div class="col-md-6 mb-3">
      <img src="../imagenes/MEDICOS.jpg" alt="Consultorio Clínico" class="img-fluid rounded shadow">
    </div>

    <!-- Mensaje para médicos -->
    <div class="col-md-6">
      <h5 class="text-primary">👨‍⚕️ ¿Eres médico?</h5>
      <p>Nos encantaría contar con tu experiencia. Si deseas formar parte de nuestro equipo clínico, contacta con soporte para iniciar tu incorporación:</p>
      <ul>
        <li>📧 <strong>Email:</strong> soporte@consultoriommc.com</li>
        <li>📞 <strong>Teléfono:</strong> +506 2222-3333</li>
        <li>💬 <strong>WhatsApp:</strong> +506 8888-9999</li>
      </ul>
      <p class="mt-2">Juntos podemos brindar atención médica de calidad a más personas.</p>
    </div>
  </div>
</div>


    <!-- Contenido de Quiropodia -->
    <div class="row collapse" id="quiropodiaSection">
      <div class="col-lg-8">
        <!-- Artículo 1 -->
        <div class="card mb-4">
          <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Patologías - Onicopatías más comunes</h5>
          </div>
          <div class="card-body">
            <div class="row g-2 galeria-collage">
              <div class="col-md-6"><img src="../imagenes/Fondo.png" alt="Fondo"></div>
              <div class="col-md-6"><img src="../imagenes/Pie1.png" alt="Pie1"></div>
              <div class="col-md-6"><img src="../imagenes/Pie2.png" alt="Pie2"></div>
              <div class="col-md-6"><img src="../imagenes/Pie3.png" alt="Pie3"></div>
              <div class="col-md-6"><img src="../imagenes/Pie4.png" alt="Pie4"></div>
            </div>
            <p class="mt-3 text-muted">
              Derechos de autor <cite>MMC Quiropodia</cite> |
              <time datetime="2025-06-28">Publicado: 28-06-2025</time>
            </p>
          </div>
        </div>

        <!-- Artículo 2 -->
        <div class="card mb-4">
          <div class="card-body">
            <img src="../imagenes/Flyer_MMC.png" alt="Flyer" class="img-fluid rounded mb-3">
            <figcaption class="mb-2">🧠 Lo que el cerebro ignora, los ojos no lo ven!</figcaption>
            <figcaption class="mb-2">📅 Agenda tu cita!</figcaption>
            <h5 class="mt-3">También tenemos productos para el cuidado diario de tus pies!</h5>
            <h6 class="mt-3">
              <a href="https://maps.app.goo.gl/EHS3DWV9aNiaHRBw8" class="map-link text-success" target="_blank">
                📍 Resultados desde la primera cita!
              </a>
            </h6>
          </div>
        </div>
      </div>

      <!-- Aside / lateral -->
      <div class="col-lg-4">
        <div class="card shadow mb-4">
          <div class="card-body">
            <blockquote class="blockquote mb-3">
              <p>👩‍⚕️ Profesional en Quiropodia</p>
            </blockquote>
            <img src="../imagenes/Profesional.png" alt="Profesional" class="aside-img mb-2">
            <figcaption>💢 A quien le duelen los pies, le duele todo!</figcaption>
            <figcaption class="mt-2">📞 Agendá tu cita!</figcaption>
          </div>
        </div>
      </div>

        <!-- Bloque de contacto -->
  <div class="col-12">
    <p>Nos encantaría brindarte la atención médica que mereces. Si deseas realizar una revisión clínica, contactá a nuestro equipo profesional y agendá tu cita a través del área de soporte. Así podrás iniciar tu incorporación al sistema de salud con nosotros:</p>
    <ul>
      <li>📧 <strong>Email:</strong> soporte@consultoriommc.com</li>
      <li>📞 <strong>Teléfono:</strong> +506 2222-3333</li>
      <li>💬 <strong>WhatsApp:</strong> +506 8888-9999</li>
    </ul>
    <div class="text-center mt-3">
      <a href="Index.php" class="btn btn-outline-secondary">← Volver a inicio</a>
    </div>
  </div>


      <footer class="text-center text-muted py-3">
        <small>&copy; 2025 Derechos Reservados - MMC Quiropodia</small>
      </footer>
    </div>

    <!-- Sección desplegable de Pediatría -->
    <div class="collapse mt-4" id="pediatriaSection">
      <div class="card card-body border-primary">
        <h5 class="text-primary">👶 Atención Pediátrica Integral</h5>
        <p>Contamos con especialistas en el cuidado infantil, desde neonatología hasta adolescencia. Nuestro enfoque es cálido, profesional y adaptado a cada etapa del desarrollo.</p>
        <div class="row g-3 galeria-collage">
          <div class="col-md-6"><img src="../imagenes/pediatria.jpg" alt="Pediatría 1"></div>
          <div class="col-md-6"><img src="../imagenes/pediatria2.jpg" alt="Pediatría 2"></div>
        </div>
        <p class="mt-2 text-muted">👩‍⚕️ Tu tranquilidad comienza con una buena consulta pediátrica.</p>

      </div>

        <!-- Bloque de contacto -->
  <div class="col-12">
    <figcaption class="mt-2">📅 Agendá tu cita!</figcaption>
    <p>Nos encantaría brindarte la atención médica que mereces. Si deseas realizar una revisión clínica, contactá a nuestro equipo profesional y agendá tu cita a través del área de soporte. Así podrás iniciar tu incorporación al sistema de salud con nosotros:</p>
    <ul>
      <li>📧 <strong>Email:</strong> soporte@consultoriommc.com</li>
      <li>📞 <strong>Teléfono:</strong> +506 2222-3333</li>
      <li>💬 <strong>WhatsApp:</strong> +506 8888-9999</li>
    </ul>
    <div class="text-center mt-3">
      <a href="Index.php" class="btn btn-outline-secondary">← Volver a inicio</a>
    </div>
  </div>

      <footer class="text-center text-muted py-3">
        <small>&copy; 2025 Derechos Reservados - DA Pediatría</small>
      </footer>
    </div>

    <!-- Sección desplegable de Cardiología -->
    <div class="collapse mt-4" id="cardiologiaSection">
      <div class="card card-body border-danger">
        <h5 class="text-danger">❤️ Cardiología</h5>
        <p>Realizamos electrocardiogramas, ecocardiografías y chequeos preventivos para cuidar tu salud cardiovascular.</p>
        <div class="row g-3 galeria-collage">
          <div class="col-md-6"><img src="../imagenes/cardiologia.jpg" alt="Cardiología 1"></div>
          <div class="col-md-6"><img src="../imagenes/cardiologia2.jpg" alt="Cardiología 2"></div>
        </div>
        <p class="mt-2 text-muted">🫀 Tu corazón merece atención especializada.</p>
      </div>

        <!-- Bloque de contacto -->
  <div class="col-12">
    <figcaption class="mt-2">📅 Agendá tu cita!</figcaption>
    <p>Nos encantaría brindarte la atención médica que mereces. Si deseas realizar una revisión clínica, contactá a nuestro equipo profesional y agendá tu cita a través del área de soporte. Así podrás iniciar tu incorporación al sistema de salud con nosotros:</p>
    <ul>
      <li>📧 <strong>Email:</strong> soporte@consultoriommc.com</li>
      <li>📞 <strong>Teléfono:</strong> +506 2222-3333</li>
      <li>💬 <strong>WhatsApp:</strong> +506 8888-9999</li>
    </ul>
    <div class="text-center mt-3">
      <a href="Index.php" class="btn btn-outline-secondary">← Volver a inicio</a>
    </div>
  </div>


      <footer class="text-center text-muted py-3">
        <small>&copy; 2025 Derechos Reservados - DA Cardiología</small>
      </footer>
    </div>

    <!-- Sección desplegable de Dermatología -->
    <div class="collapse mt-4" id="dermatologiaSection">
      <div class="card card-body border-warning">
        <h5 class="text-warning">🧴 Dermatología</h5>
        <p>Tratamos afecciones de la piel, cabello y uñas con enfoque médico y estético.</p>
        <div class="row g-3 galeria-collage">
          <div class="col-md-6"><img src="../imagenes/dermatologia1.jpg" alt="Dermatología 1"></div>
          <div class="col-md-6"><img src="../imagenes/dermatologia2.png" alt="Dermatología 2"></div>
        </div>
        <p class="mt-2 text-muted">🌞 Tu piel habla de tu bienestar.</p>
      </div>

  <!-- Bloque de contacto -->
  <div class="col-12">
    <figcaption class="mt-2">📅 Agendá tu cita!</figcaption>
    <p>Nos encantaría brindarte la atención médica que mereces. Si deseas realizar una revisión clínica, contactá a nuestro equipo profesional y agendá tu cita a través del área de soporte. Así podrás iniciar tu incorporación al sistema de salud con nosotros:</p>
    <ul>
      <li>📧 <strong>Email:</strong> soporte@consultoriommc.com</li>
      <li>📞 <strong>Teléfono:</strong> +506 2222-3333</li>
      <li>💬 <strong>WhatsApp:</strong> +506 8888-9999</li>
    </ul>
    <div class="text-center mt-3">
      <a href="Index.php" class="btn btn-outline-secondary">← Volver a inicio</a>
    </div>
  </div>

      <footer class="text-center text-muted py-3">
        <small>&copy; 2025 Derechos Reservados - DA Dermatología</small>
      </footer>
    </div>

    <!-- Sección desplegable de Medicina General -->
    <div class="collapse mt-4" id="medicinaSection">
      <div class="card card-body border-success">
        <h5 class="text-success">🩺 Medicina General</h5>
        <p>Consultas médicas integrales, seguimiento de enfermedades crónicas y orientación preventiva.</p>
        <div class="row g-3 galeria-collage">
          <div class="col-md-6"><img src="../imagenes/medicina1.jpg" alt="Medicina General 1"></div>
          <div class="col-md-6"><img src="../imagenes/medicina2.jpg" alt="Medicina General 2"></div>
        </div>
        <p class="mt-2 text-muted">👨‍⚕️ Tu salud, nuestra prioridad diaria.</p>
      </div>
        <!-- Bloque de contacto -->
  <div class="col-12">
    <figcaption class="mt-2">📅 Agendá tu cita!</figcaption>
    <p>Nos encantaría brindarte la atención médica que mereces. Si deseas realizar una revisión clínica, contactá a nuestro equipo profesional y agendá tu cita a través del área de soporte. Así podrás iniciar tu incorporación al sistema de salud con nosotros:</p>
    <ul>
      <li>📧 <strong>Email:</strong> soporte@consultoriommc.com</li>
      <li>📞 <strong>Teléfono:</strong> +506 2222-3333</li>
      <li>💬 <strong>WhatsApp:</strong> +506 8888-9999</li>
    </ul>
    <div class="text-center mt-3">
      <a href="Index.php" class="btn btn-outline-secondary">← Volver a inicio</a>
    </div>
  </div>
      <footer class="text-center text-muted py-3">
        <small>&copy; 2025 Derechos Reservados - DA Medicina General</small>
      </footer>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function ocultarTodo() {
      document.getElementById('bienvenida').style.display = 'none';
      document.getElementById('quiropodiaSection').classList.remove('show');
      document.getElementById('pediatriaSection').classList.remove('show');
      document.getElementById('cardiologiaSection').classList.remove('show');
      document.getElementById('dermatologiaSection').classList.remove('show');
      document.getElementById('medicinaSection').classList.remove('show');
    }

    function mostrarSoloQuiropodia() {
      ocultarTodo();
      new bootstrap.Collapse(document.getElementById('quiropodiaSection'), { toggle: true });
    }

    // function mostrarSoloPediatria() {
    //   ocultarTodo();
    //   new bootstrap.Collapse(document.getElementById('pediatriaSection'), { toggle: true });
    // }

    // function mostrarSoloCardiologia() {
    //   ocultarTodo();
    //   new bootstrap.Collapse(document.getElementById('cardiologiaSection'), { toggle: true });
    // }

    // function mostrarSoloDermatologia() {
    //   ocultarTodo();
    //   new bootstrap.Collapse(document.getElementById('dermatologiaSection'), { toggle: true });
    // }

    // function mostrarSoloMedicina() {
    //   ocultarTodo();
    //   new bootstrap.Collapse(document.getElementById('medicinaSection'), { toggle: true });
    // }
  </script>
</body>
</html>


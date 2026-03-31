<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="description" content="Consultorio de Quiropodia MMC">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MMC Quiropodia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .galeria-collage {
      display: grid;
      grid-template-columns: repeat(4, 1fr); /* tres columnas iguales */
      gap: 1px; /* espacio entre imágenes */
      margin-top: 5px;
    }

    .galeria-collage img {
      width: 100%;
      height: 180px; /* ajusta la altura si quieres más grandes o pequeñas */
      object-fit: cover;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
      transition: transform 0.2s ease-in-out;
    }
    .galeria-collage img:hover {
      transform: scale(1.05);
    }
    .aside-img {
      width: 75%;
      text-align: center;
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-3 rounded shadow">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">MMC Quiropodia</a>
        <div class="collapse navbar-collapse">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link active" href="#">Calendario</a></li>
            <li class="nav-item"><a class="nav-link" href="perfil_paciente.php">Pacientes</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Contenido principal -->
    <div class="row">
      <div class="col-lg-8">
        <!-- Articulo 1 -->
        <div class="card mb-4">
          <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Patologias - Onicopatias mas comunes</h5>
          </div>
          <div class="card-body">
            <div class="row g-3 galeria-collage">
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

        <!-- Articulo 2 -->
        <div class="card mb-4">
          <div class="card-body">
            <img src="../imagenes/Flyer_MMC.png" alt="Flyer" class="img-fluid rounded mb-3">
            <figcaption class="mb-2">🧠 Lo que el cerebro ignora, los ojos no lo ven!</figcaption>
            <figcaption class="mb-2">📅 Agenda tu cita!</figcaption>
            <h5 class="mt-3">Tambien tenemos productos para el cuidado diario de tus pies!</h5>
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
            <figcaption class="mt-2">📞 Agenda tu cita!</figcaption>
          </div>
        </div>

        <!-- Bloque de contacto -->
        <div class="card shadow">
          <div class="card-body">
            <h5 class="text-primary mb-3">Contacto</h5>
            <ul class="list-unstyled">
              <li>📧 <strong>Email:</strong> mmcquiropodia@gmail.com</li>
              <li>📞 <strong>Telefono:</strong> +506 8749-9180</li>
              <li>💬 <strong>WhatsApp:</strong> +506 8749-9180</li>
            </ul>
            <div class="text-center mt-3">
              <a href="perfil_paciente.php" class="btn btn-success">Ver pacientes</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <footer class="text-center text-muted py-3 mt-4">
      <small>&copy; 2025 Derechos Reservados - MMC Quiropodia</small>
    </footer>
  </div>

</body>
</html>

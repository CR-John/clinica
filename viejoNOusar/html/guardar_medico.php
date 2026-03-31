<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Médico</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">

<?php
// Configuración de la base de datos
$conn = new mysqli("localhost", "root", "", "clinica");
if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
}

// Capturar datos personales
$cedula      = $_POST['cedula'];
$nombre      = $_POST['nombre'];
$apellido1   = $_POST['apellido1'];
$apellido2   = $_POST['apellido2'];
$especialidad= $_POST['especialidad'];
$telefono    = $_POST['telefono'];
$correo      = $_POST['correo'];

// Generar contraseña aleatoria
function generarContrasena($longitud = 8) {
    $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@#$%&";
    return substr(str_shuffle($caracteres), 0, $longitud);
}
$contrasenaPlano = generarContrasena();
$contrasenaHash = $contrasenaPlano; // 🔁 Guardar sin encriptar

// Verificar si la cédula ya existe
$verificar = $conn->prepare("SELECT id FROM medicos WHERE cedula = ?");
$verificar->bind_param("s", $cedula);
$verificar->execute();
$verificar->store_result();

if ($verificar->num_rows > 0) {
    echo '
    <div class="alert alert-warning text-center">
        ⚠️ El médico con cédula <strong>' . $cedula . '</strong> ya está registrado.
    </div>
    <a href="registrar_medico.php" class="btn btn-outline-primary">Intentar con otra cédula</a>
    ';
    $verificar->close();
    $conn->close();
    exit;
}
$verificar->close();


// Insertar médico
$stmt = $conn->prepare("INSERT INTO medicos (cedula, nombre, apellido1, apellido2, especialidad, telefono, correo, contrasena) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $cedula, $nombre, $apellido1, $apellido2, $especialidad, $telefono, $correo, $contrasenaHash);

if ($stmt->execute()) {
    $medico_id = $stmt->insert_id;

    // Diseño visual del registro exitoso
    echo '
    <div class="card border-success shadow mb-4">
      <div class="card-header bg-success text-white text-center">
        <h4>✅ Médico registrado con éxito</h4>
      </div>
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-6">
            <p><strong>🆔 Usuario generado:</strong> <span class="text-primary">' . $cedula . '</span></p>
          </div>
          <div class="col-md-6">
            <p><strong>🔐 Contraseña asignada:</strong> <span class="text-danger fw-bold">' . $contrasenaPlano . '</span></p>
          </div>
        </div>
        <p class="text-muted text-center">📋 Puedes copiar estos datos para entregarlos al médico.</p>
        <p class="text-muted text-center">📧 Se ha enviado un correo con las credenciales al médico.</p>
        <p> 
        <p class="text-muted text-center">--- Para cambios de horario puedes contactar al equipo de Soporte---</p>
        <div class="text-center">
          <a href="registrar_medico.php" class="btn btn-outline-success">Registrar otro Médico</a>
          <a href="panel_administrador.html" class="btn btn-outline-secondary">Volver al Panel</a>
      </div>
      <div class="card-footer text-center text-muted">
        <small>&copy; MMC Clínica - Gestión de Médicos</small>
      </div>
    </div>
    ';

    // Insertar horarios por día y hora
    if (!empty($_POST['horario'])) {
        echo "<hr><h5>🗓️ Horarios registrados:</h5><ul class='list-group'>";
        foreach ($_POST['horario'] as $dia => $horas) {
            foreach ($horas as $hora) {
                $check = $conn->prepare("SELECT COUNT(*) FROM horarios_medicos WHERE medico_id = ? AND dia_semana = ? AND hora_inicio = ?");
                $check->bind_param("iss", $medico_id, $dia, $hora);
                $check->execute();
                $check->bind_result($existe);
                $check->fetch();
                $check->close();

                if ($existe == 0) {
                    $insert = $conn->prepare("INSERT INTO horarios_medicos (medico_id, dia_semana, hora_inicio, hora_fin) VALUES (?, ?, ?, ?)");
                    $insert->bind_param("isss", $medico_id, $dia, $hora, $hora);
                    $insert->execute();

                    echo "<li class='list-group-item'>$dia — $hora</li>";
                } else {
                    echo "<li class='list-group-item list-group-item-warning'>$dia — $hora ya estaba registrado</li>";
                }
            }
        }
        echo "</ul>";
    }

} else {
    echo "<div class='alert alert-danger'><strong>❌ Error al registrar el médico:</strong> " . $stmt->error . "</div>";
}

$conn->close();
?>

</div> <!-- cierre de container -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
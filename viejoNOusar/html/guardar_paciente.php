<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro Exitoso</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">

<?php
// Configuración de conexión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clinica";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Capturar datos del formulario
$cedula = $_POST['cedula'];
$nombre = $_POST['nombre'];
$apellido1 = $_POST['apellido1'];
$apellido2 = $_POST['apellido2'];
$edad = $_POST['edad'];
$estado_paciente = $_POST['estado_paciente'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$direccion = $_POST['direccion'];

// Generar contraseña aleatoria
function generarContrasena($longitud = 6) {
    $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    return substr(str_shuffle($caracteres), 0, $longitud);
}

$contrasenaPlano = generarContrasena();
$contrasenaHash = password_hash($contrasenaPlano, PASSWORD_DEFAULT);

// Verificar si la cédula ya existe
$verificar_sql = "SELECT cedula FROM pacientes WHERE cedula = '$cedula'";
$resultado = $conn->query($verificar_sql);

if ($resultado->num_rows > 0) {
    echo '
    <div class="alert alert-warning text-center">
      ⚠️ El paciente con cédula <strong>' . $cedula . '</strong> ya está registrado.
    </div>
    <a href="registrar_paciente.html" class="btn btn-outline-primary">Intentar con otra cédula</a>
    ';
} else {
    // Insertar datos
    $sql = "INSERT INTO pacientes (cedula, nombre, apellido1, apellido2, edad, estado_paciente, telefono, correo, direccion, contrasena)
            VALUES ('$cedula', '$nombre', '$apellido1', '$apellido2', '$edad', '$estado_paciente', '$telefono', '$correo', '$direccion', '$contrasenaHash')";

    if ($conn->query($sql) === TRUE) {
        echo '
        <!--
        <div class="card border-success shadow">
          <div class="card-header bg-success text-white text-center">
            <h4>✅ Paciente registrado con éxito</h4>
          </div>
          <div class="card-body">
            <p><strong>🆔 Usuario generado:</strong> ' . $cedula . '</p>
            <p><strong>🔐 Contraseña asignada:</strong> ' . $contrasenaPlano . '</p>
            <p class="text-muted">📧 Se ha enviado un correo con las credenciales al paciente.</p>
          </div>
          <div class="card-footer text-center text-muted">
            <small>&copy; MMC Clínica - Gestión de Pacientes</small>
          </div>
        </div>
        -->
        ';

        // Enviar correo al paciente sin la contraseña
        $asunto = "Registro exitoso - Clínica";
        $mensaje = "Hola $nombre,\n\nTu registro como paciente ha sido exitoso. Gracias por confiar en nosotros.\n\nMMC Clínica";
        $cabeceras = "From: clinica@example.com";
        mail($correo, $asunto, $mensaje, $cabeceras);

        // Panel de confirmación
        echo '
        <div class="card border-success shadow">
          <div class="card-header bg-success text-white text-center">
            <h4>✅ Paciente registrado con éxito</h4>
          </div>
          <div class="card-body">
            <p><strong>🆔 Usuario registrado:</strong> ' . $cedula . '</p>
            <p class="text-muted">📧 Se ha enviado un correo notificando el registro.</p>
          </div>
          <div class="card-footer text-center text-muted">
            <small>&copy; MMC Clínica - Gestión de Pacientes</small>
          </div>
        </div>
        ';

        // Botones de navegación
        echo '
        <div class="text-center">
        <p></p>
            <a href="panel_administrador.html" class="btn btn-outline-secondary">Volver al Panel</a>
            <a href="listar_pacientes.php" class="btn btn-outline-info">Ver Pacientes Registrados</a>
            <a href="registrar_paciente.html" class="btn btn-outline-success">Registrar Otro Paciente</a>
        </div>
        ';
    } else {
        echo "❌ Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

</div> <!-- container -->
</body>
</html>
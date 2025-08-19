<?php
session_start();

// Conexion BD
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clinica";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Conexion fallida: " . $conn->connect_error);
}

// Recibir datos
$usuario = trim($conn->real_escape_string($_POST['usuario']));// para medicos: cedula
$contrasena = trim($conn->real_escape_string($_POST['contrasena']));
$rol = trim($conn->real_escape_string($_POST['rol']));


switch ($rol) {
  case "medico":
    $sql = "SELECT * FROM medicos WHERE cedula = '$usuario' AND contrasena = '$contrasena'";
    $panel = "panel_medico.php";
    break;

  case "admin":
    $sql = "SELECT * FROM admins WHERE usuario = '$usuario' AND contrasena = '$contrasena'";
    $panel = "panel_administrador.html";
    break;

  default:
    echo "Rol no válido.";
    exit;
}

$result = $conn->query($sql);

if(!$result) {
    die("Error en la consulta: ".$conn->error);
}

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $_SESSION['usuario'] = $rol === 'medico' ? $row['cedula'] : $row['usuario'];
  $_SESSION['rol'] = $rol;

  header("Location: $panel");
  exit;
} else {
  echo "❌ Usuario o contraseña incorrectos.";
}

$conn->close();
?>

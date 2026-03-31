<?php
session_start();
$_SESSION['usuario_id'] = $id_usuario;
$_SESSION['usuario_tipo'] = 'medico'; 

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
  
  $_SESSION['usuario_id'] = $row['id']; // ID del usuario (medico o admin)
  $_SESSION['usuario_tipo'] = $rol;     // 'medico' o 'admin'
  $_SESSION['usuario'] = $rol === 'medico' ? $row['cedula'] : $row['usuario'];

  $panel = $rol === 'medico' ? 'panel_medico.php' : 'panel_administrador.html';
  header("Location: $panel");
  exit;
} else {
    $_SESSION['error'] = "Usuario o contraseña incorrectos";
    header("Location: index.php");
    exit;
}


$conn->close();
?>

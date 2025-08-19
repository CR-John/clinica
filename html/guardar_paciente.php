<?php
// Configuración de conexión
$servername = "localhost";
$username = "root";   // usuario por defecto en Laragon
$password = "";       // contraseña vacía en Laragon
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
//$fecha_acimiento = $_POST['fecha_nacimiento'];
$edad = $_POST['edad'];
$estado_paciente = $_POST['estado_paciente'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$direccion = $_POST['direccion'];

// Generar contraseña aleatoria
//function generarContrasena($longitud = 4) {
//    $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
//    return substr(str_shuffle($caracteres), 0, $longitud);
//}

//$contrasenaPlano = generarContrasena();
//$contrasenaHash = password_hash($contrasenaPlano, PASSWORD_DEFAULT);

// Insertar datos
$sql = "INSERT INTO pacientes (cedula, nombre, apellido1, apellido2, edad, estado_paciente, telefono, correo, direccion, contrasena)
        VALUES ('$cedula', '$nombre', '$apellido1', '$apellido2', '$edad', '$estado_paciente', '$telefono', '$correo', '$direccion')";
        //VALUES ('$cedula', '$nombre', '$apellido1', '$apellido2', '$edad', '$estado_paciente', '$telefono', '$correo', '$direccion', '$contrasenaHash')";

if ($conn->query($sql) === TRUE) {
    echo "<h2>✅ Paciente registrado con éxito</h2>";
    echo "Usuario generado: <strong>$cedula</strong><br>";
    //echo "Contraseña asignada: <strong>$contrasenaPlano</strong><br>";

    // Enviar correo al paciente con la contraseña
    //$asunto = "Credenciales de acceso - Clínica";
    //$mensaje = "Hola $nombre,\n\nTu usuario es: $cedula\nTu contraseña es: $contrasenaPlano\n\nPor favor cámbiala después de iniciar sesión.";
    //$cabeceras = "From: clinica@example.com";
    //mail($correo, $asunto, $mensaje, $cabeceras);

    // Botones de navegación
    echo "<br><br>";
    echo "<a href='panel_administrador.html' class='btn btn-outline-secondary'>Volver al Panel</a>";
    echo "<br><br>";
    echo "<a href='listar_pacientes.php' class='btn btn-outline-info'>Ver Pacientes Registrados</a>";
    echo "<br><br>";
    echo "<a href='registrar_paciente.html' class='btn btn-outline-success'>Registrar Otro Paciente</a>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

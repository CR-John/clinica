<?php
// Configuracion BD
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clinica";

// Conexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexion
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

// Capturar datos
$cedula = $_POST['cedula'];
$nombre = $_POST['nombre'];
$apellido1 = $_POST['apellido1'];
$apellido2 = $_POST['apellido2'];
$especialidad = $_POST['especialidad'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];

// Generar contraseña aleatoria 
function generarContrasena($longitud = 8) {
    $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@#$%&";
    return substr(str_shuffle($caracteres), 0, $longitud);
}
$contrasenaPlano = generarContrasena();

// Guardar en BD 
$sql = "INSERT INTO medicos (cedula, nombre, apellido1, apellido2, especialidad, telefono, correo, contrasena)
        VALUES ('$cedula', '$nombre', '$apellido1', '$apellido2', '$especialidad', '$telefono', '$correo', '$contrasenaPlano')";

if ($conn->query($sql) === TRUE) {
    $medico_id = $conn->insert_id; // id del medico recién registrado
    echo "<h2>✅ Médico registrado con exito</h2>";
    echo "Usuario generado: <strong>$cedula</strong><br>";
    echo "Contraseña asignada: <strong>$contrasenaPlano</strong><br>";

    //Insertar horarios si se seleccionaron
    if (!empty($_POST['dias'])) {
        foreach ($_POST['dias'] as $dia) {
            $horaInicio = $_POST['horaInicio'][$dia];
            $horaFin = $_POST['horaFin'][$dia];

            $sqlHorario = "INSERT INTO horarios_medicos (medico_id, dia_semana, hora_inicio, hora_fin)
                           VALUES ('$medico_id', '$dia', '$horaInicio', '$horaFin')";
            $conn->query($sqlHorario);
        }
    }

    // Enviar correo con las credenciales
    $asunto = "Credenciales de acceso - Clinica";
    $mensaje = "Hola Dr. $nombre,\n\nTu usuario es: $cedula\nTu contraseña es: $contrasenaPlano\n\nPor favor cambiala al ingresar.";
    $cabeceras = "From: clinica@example.com";
    mail($correo, $asunto, $mensaje, $cabeceras);

    echo "<br><br>";
    echo "<a href='panel_administrador.html' class='btn btn-outline-secondary'>Volver al Panel</a>";
    echo "<br><br>";
    echo "<a href='listar_medicos.php' class='btn btn-outline-info'>Ver Medicos Registrados</a>";
    echo "<br><br>";
    echo "<a href='registrar_medico.html' class='btn btn-outline-success'>Registrar Otro Medico</a>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

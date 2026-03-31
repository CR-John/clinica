<?php
session_start();

// Verifica que sea medico
if(!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] != 'medico'){
    header("Location: login.php");
    exit;
}

$medico_id = $_SESSION['usuario_id'];

$conn = new mysqli("localhost","root","","clinica");
if($conn->connect_error) die("Conexion fallida: ".$conn->connect_error);

// Obtenemos apellido del medico
$sqlMedico = "SELECT apellido1 FROM medicos WHERE id = ?";
$stmtMedico = $conn->prepare($sqlMedico);
$stmtMedico->bind_param("i", $medico_id);
$stmtMedico->execute();
$stmtMedico->bind_result($apellidoMedico);
$stmtMedico->fetch();
$stmtMedico->close();

// Traemos citas del medico desde la BD
$sql = "
SELECT c.id, p.nombre AS paciente, p.apellido1, c.fecha, c.hora, c.motivo
FROM citas c
JOIN pacientes p ON c.paciente_id=p.id
WHERE c.medico_id = ?
ORDER BY c.fecha, c.hora
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$medico_id);
$stmt->execute();
$res = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel Médico</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="d-flex justify-content-between mb-4">
         <h3>Bienvenido Dr. <?php echo $apellidoMedico; ?></h3>  <!--Mostramos apellido del medico -->
        <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
    </div>

    <h4>📅 Mis Citas</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Paciente</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Motivo</th>
                <th>Comprobante</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $res->fetch_assoc()): ?> <!-- Se hace la consulta de las citas asociuadas al medico a la BD-->
                <tr>
                    <td><?php echo $row['paciente']." ".$row['apellido1']; ?></td>
                    <td><?php echo $row['fecha']; ?></td>
                    <td><?php echo $row['hora']; ?></td>
                    <td><?php echo $row['motivo']; ?></td>
                    <td>
                        <a href="comprobante.php?cita_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Emitir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h4>🩺 Diagnósticos</h4>
    <a href="diagnosticos.php" class="btn btn-success mb-4">Ir a Diagnósticos</a>
</div>
</body>
</html>
<?php $conn->close(); ?>

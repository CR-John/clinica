<?php
session_start();
$medico_id = $_SESSION['usuario_id']; // ID del médico logueado

$conn = new mysqli("localhost", "root", "", "clinica");
$sql = "
SELECT c.id, p.nombre AS paciente, p.apellido1, c.fecha, c.hora, c.motivo
FROM citas c
JOIN pacientes p ON c.paciente_id = p.id
WHERE c.medico_id = ?
ORDER BY c.fecha, c.hora
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $medico_id);
$stmt->execute();
$res = $stmt->get_result();
?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Paciente</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Motivo</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $res->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['paciente']." ".$row['apellido1']; ?></td>
                <td><?php echo $row['fecha']; ?></td>
                <td><?php echo $row['hora']; ?></td>
                <td><?php echo $row['motivo']; ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

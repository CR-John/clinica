<?php
$conn = new mysqli("localhost", "root", "", "clinica");
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

// Traer médicos y sus horarios
$sql = "SELECT m.cedula, m.nombre, m.apellido1, m.apellido2, m.especialidad, m.telefono, m.correo, m.contrasena,
               h.dia_semana, h.hora_inicio, h.hora_fin
        FROM medicos m
        LEFT JOIN horarios_medicos h ON m.id = h.medico_id
        ORDER BY m.nombre, FIELD(h.dia_semana,'Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo')";

$result = $conn->query($sql);

echo "<h2>Lista de Medicos</h2>";
echo "<table border='1' cellpadding='5'>
<tr>
<th>Cedula</th>
<th>Nombre</th>
<th>Apellido1</th>
<th>Apellido2</th>
<th>Especialidad</th>
<th>Telefono</th>
<th>Correo</th>
<th>Contrasena</th>
<th>Horario</th>
</tr>";

if ($result->num_rows > 0) {
    $medicos = [];
    // Agrupar horarios por médico
    while($row = $result->fetch_assoc()) {
        $id = $row['cedula']; // o id si lo preferís
        if (!isset($medicos[$id])) {
            $medicos[$id] = $row;
            $medicos[$id]['horarios'] = [];
        }
        if ($row['dia_semana']) {
            $medicos[$id]['horarios'][] = $row['dia_semana'] . " " . $row['hora_inicio'] . " - " . $row['hora_fin'];
        }
    }

    // Mostrar cada médico con sus horarios
    foreach($medicos as $medico) {
        echo "<tr>
                <td>".$medico['cedula']."</td>
                <td>".$medico['nombre']."</td>
                <td>".$medico['apellido1']."</td>
                <td>".$medico['apellido2']."</td>
                <td>".$medico['especialidad']."</td>
                <td>".$medico['telefono']."</td>
                <td>".$medico['correo']."</td>
                <td>".$medico['contrasena']."</td>
                <td>".implode("<br>", $medico['horarios'])."</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='9'>No hay medicos registrados</td></tr>";
}

echo "</table>";
echo "<br><a href='panel_administrador.html' class='btn btn-outline-secondary'>Volver al Panel</a>";

$conn->close();
?>

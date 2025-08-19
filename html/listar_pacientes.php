<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clinica";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT * FROM pacientes";
$result = $conn->query($sql);

echo "<h2>Lista de Pacientes</h2>";
echo "<table border='1' cellpadding='5'>
        <tr><th>ID</th><th>Nombre</th><th>Apellido1</th><th>Apellido2</th><th>Edad</th><th>Estado del Paciente</th><th>Teléfono</th><th>Correo</th><th>Direccion</th></tr>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row["cedula"]."</td>
                <td>".$row["nombre"]."</td>
                <td>".$row["apellido1"]."</td>
                <td>".$row["apellido2"]."</td>
                <td>".$row["edad"]."</td>
                <td>".$row["estado_paciente"]."</td>
                <td>".$row["telefono"]."</td>
                <td>".$row["correo"]."</td>
                <td>".$row["direccion"]."</td>
              </tr>";
    }
    
} else {
    echo "<tr><td colspan='6'>No hay pacientes registrados</td></tr>";
}
echo "</table>";
echo "<br><br>";
echo "<a href='panel_administrador.html' class='btn btn-outline-secondary'>Volver al Panel</a>";
echo "<br><br>";

$conn->close();
?>

<?php
$servername = "localhost";
$username = "root";
$password = ""; // o el que tengas configurado
$dbname = "consultorio";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>



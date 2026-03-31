<?php include_once("includes-db.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Pacientes - Quiropodia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="mb-4 text-center">Perfiles de Pacientes</h2>

    <form action="index.php" method="post" class="mb-4 d-flex justify-content-center">
      <input type="text" name="nombre" class="form-control w-25 me-2" placeholder="Nombre del paciente" required>
      <input type="number" name="edad" class="form-control w-25 me-2" placeholder="Edad">
      <input type="text" name="telefono" class="form-control w-25 me-2" placeholder="Teléfono">
      <button type="submit" name="agregar" class="btn btn-primary">Agregar</button>
    </form>

    <?php
    if (isset($_POST['agregar'])) {
      $nombre = $_POST['nombre'];
      $edad = $_POST['edad'];
      $telefono = $_POST['telefono'];
      $conn->query("INSERT INTO pacientes (nombre, edad, telefono) VALUES ('$nombre', '$edad', '$telefono')");
      echo "<div class='alert alert-success text-center'>Paciente agregado correctamente</div>";
    }

    $result = $conn->query("SELECT * FROM pacientes ORDER BY nombre ASC");
    ?>
    <table class="table table-bordered table-hover bg-white shadow-sm">
      <thead class="table-primary">
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Edad</th>
          <th>Teléfono</th>
          <th>Fecha Registro</th>
          <th>Perfil</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['nombre']) ?></td>
          <td><?= $row['edad'] ?></td>
          <td><?= htmlspecialchars($row['telefono']) ?></td>
          <td><?= $row['fecha_registro'] ?></td>
          <td><a href="perfil.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info">Ver</a></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

    <a href="../html/index.php" class="btn btn-secondary mt-3">Volver al Inicio</a>
  </div>
</body>
</html>

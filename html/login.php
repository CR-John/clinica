<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $usuario = $_POST['usuario'];
  $clave = $_POST['clave'];

  // Usuario definido por el admin (puedes cambiarlo)
  if ($usuario === "admin" && $clave === "12345678") {
    $_SESSION['usuario'] = $usuario;
    header("Location: index.php");
    exit();
  } else {
    $error = "Credenciales incorrectas";
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Ingreso - Consultorio</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="col-md-4 mx-auto card shadow-sm p-4">
    <h4 class="text-center mb-4">Acceso al sistema</h4>
    <?php if(isset($error)): ?>
      <div class="alert alert-danger"><?=$error?></div>
    <?php endif; ?>
    <form method="POST">
      <input type="text" name="usuario" class="form-control mb-3" placeholder="Usuario" required>
      <input type="password" name="clave" class="form-control mb-3" placeholder="Clave (8 caracteres)" minlength="3" required>
      <button class="btn btn-primary w-100">Ingresar</button>
    </form>
  </div>
</div>
</body>
</html>

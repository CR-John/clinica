<?php
$conn = new mysqli("localhost","root","","consultorio");
if($conn->connect_error) die("Conexion fallida: ".$conn->connect_error);

$paciente_id = $_GET['id'] ?? 0;
$paciente = [];
$notas = [];
$fotos = [];

if($paciente_id){
    $stmt = $conn->prepare("SELECT * FROM pacientes WHERE id=?");
    $stmt->bind_param("i",$paciente_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $paciente = $res->fetch_assoc();
    $stmt->close();

    $resNotas = $conn->query("SELECT * FROM notas WHERE paciente_id=$paciente_id");
    while($row=$resNotas->fetch_assoc()) $notas[] = $row['nota'];

    $uploadDir = __DIR__."/uploads/paciente_$paciente_id";
    if(is_dir($uploadDir)){
        $files = scandir($uploadDir);
        foreach($files as $file){
            if(in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg','jpeg','png','gif'])){
                $fotos[] = "uploads/paciente_$paciente_id/$file";
            }
        }
    }
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $edad = $_POST['edad'];
    $telefono = $_POST['telefono'];
    $nota_sesion = $_POST['nota_sesion'] ?? [];

    if($paciente_id){
        $stmt = $conn->prepare("UPDATE pacientes SET nombre=?, apellido=?, edad=?, telefono=? WHERE id=?");
        $stmt->bind_param("ssisi",$nombre,$apellido,$edad,$telefono,$paciente_id);
        $stmt->execute();
        $stmt->close();
    } else {
        $stmt = $conn->prepare("INSERT INTO pacientes (nombre,apellido,edad,telefono) VALUES (?,?,?,?)");
        $stmt->bind_param("ssis",$nombre,$apellido,$edad,$telefono);
        $stmt->execute();
        $paciente_id = $stmt->insert_id;
        $stmt->close();
    }

    $uploadDir = __DIR__."/uploads/paciente_$paciente_id";
    if(!is_dir($uploadDir)) mkdir($uploadDir,0777,true);

    if(!empty($_FILES['fotos']['name'][0])){
        foreach($_FILES['fotos']['tmp_name'] as $key=>$tmp_name){
            $filename = basename($_FILES['fotos']['name'][$key]);
            move_uploaded_file($tmp_name, "$uploadDir/$filename");
        }
    }

    $conn->query("DELETE FROM notas WHERE paciente_id=$paciente_id");
    if(!empty($nota_sesion)){
        $stmt = $conn->prepare("INSERT INTO notas (paciente_id, nota) VALUES (?,?)");
        foreach($nota_sesion as $nota){
            $stmt->bind_param("is",$paciente_id,$nota);
            $stmt->execute();
        }
        $stmt->close();
    }

    header("Location: perfil_paciente.php?id=$paciente_id");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Perfil Paciente</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background-color: #f8f9fa; }
.drag-area { border: 2px dashed #6c757d; border-radius: 5px; padding: 20px; text-align: center; cursor: pointer; margin-bottom: 15px; background-color: #fff; }
.drag-area.dragover { background-color: #e9ecef; }
.preview-img { width: 100px; margin: 5px; border-radius: 5px; }
.note { background-color: #fff3cd; padding: 8px; border-left: 5px solid #ffc107; border-radius: 4px; margin-bottom: 5px; }
.session { margin-bottom: 15px; }
</style>
</head>
<body>
<div class="container py-4">
<h2 class="text-center mb-4">Perfil Paciente Editable</h2>

<form id="perfilForm" action="" method="POST" enctype="multipart/form-data">
  <div class="card mb-4 shadow-sm">
    <div class="card-header bg-primary text-white">Datos Paciente</div>
    <div class="card-body">
      <input class="form-control mb-3" type="text" name="nombre" placeholder="Nombre" value="<?=htmlspecialchars($paciente['nombre'] ?? '')?>" required>
      <input class="form-control mb-3" type="text" name="apellido" placeholder="Apellido" value="<?=htmlspecialchars($paciente['apellido'] ?? '')?>" required>
      <input class="form-control mb-3" type="number" name="edad" placeholder="Edad" value="<?=htmlspecialchars($paciente['edad'] ?? '')?>" required>
      <input class="form-control mb-3" type="text" name="telefono" placeholder="Telefono" value="<?=htmlspecialchars($paciente['telefono'] ?? '')?>">
    </div>
  </div>

  <div class="card mb-4 shadow-sm">
    <div class="card-header bg-success text-white">Album de Fotos</div>
    <div class="card-body">
      <div class="drag-area" id="dragArea">
        Arrastra fotos aqui o haz click
        <input type="file" id="fotoInput" name="fotos[]" multiple hidden accept="image/*">
      </div>
      <div id="preview" class="d-flex flex-wrap">
        <?php foreach($fotos as $foto): ?>
          <img src="<?=$foto?>" class="preview-img">
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <div class="card mb-4 shadow-sm">
    <div class="card-header bg-warning text-dark">Notas por Sesion</div>
    <div class="card-body" id="sesionesContainer">
      <?php
      if(!empty($notas)){
        foreach($notas as $n){
          echo '<div class="session mb-3"><textarea class="form-control mb-2" name="nota_sesion[]" placeholder="Escribe la nota aqui">'.htmlspecialchars($n).'</textarea></div>';
        }
      } else {
        echo '<div class="session mb-3"><textarea class="form-control mb-2" name="nota_sesion[]" placeholder="Escribe la nota aqui"></textarea></div>';
      }
      ?>
    </div>
    <button type="button" class="btn btn-outline-primary mb-3" id="addSesion">Agregar Sesion</button>
  </div>

  <div class="text-center">
    <button type="submit" class="btn btn-success">Guardar Paciente</button>
  </div>
</form>
</div>

<script>
const dragArea = document.getElementById('dragArea');
const fotoInput = document.getElementById('fotoInput');
const preview = document.getElementById('preview');

dragArea.addEventListener('click', ()=> fotoInput.click());
dragArea.addEventListener('dragover', e=>{ e.preventDefault(); dragArea.classList.add('dragover'); });
dragArea.addEventListener('dragleave', e=>{ dragArea.classList.remove('dragover'); });
dragArea.addEventListener('drop', e=>{ e.preventDefault(); dragArea.classList.remove('dragover'); handleFiles(e.dataTransfer.files); });
fotoInput.addEventListener('change', ()=> handleFiles(fotoInput.files));

function handleFiles(files){
  for(let i=0;i<files.length;i++){
    const reader=new FileReader();
    reader.onload=e=>{
      const img=document.createElement('img');
      img.src=e.target.result;
      img.classList.add('preview-img');
      preview.appendChild(img);
    }
    reader.readAsDataURL(files[i]);
  }
}

document.getElementById('addSesion').addEventListener('click', ()=>{
  const container = document.getElementById('sesionesContainer');
  const div = document.createElement('div');
  div.classList.add('session','mb-3');
  div.innerHTML=`<textarea class="form-control mb-2" name="nota_sesion[]" placeholder="Escribe la nota aqui"></textarea>`;
  container.appendChild(div);
});
</script>
</body>
</html>

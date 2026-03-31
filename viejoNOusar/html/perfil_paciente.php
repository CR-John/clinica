<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Perfil Paciente Editable</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background-color: #f8f9fa; }
.drag-area {
    border: 2px dashed #6c757d;
    border-radius: 5px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    margin-bottom: 15px;
    background-color: #ffffff;
}
.drag-area.dragover { background-color: #e9ecef; }
.preview-img { width: 100px; margin: 5px; border-radius: 5px; }
.note { background-color: #fff3cd; padding: 8px; border-left: 5px solid #ffc107; border-radius: 4px; margin-bottom: 5px; }
</style>
</head>
<body>
<div class="container py-4">
  <h2 class="text-center mb-4">Perfil Paciente Editable</h2>

  <form id="perfilForm" action="guardar_paciente.php" method="POST" enctype="multipart/form-data">
    <!-- Datos personales -->
    <div class="card mb-4 shadow-sm">
      <div class="card-header bg-primary text-white">
        Datos Paciente
      </div>
      <div class="card-body">
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
          <label for="apellido" class="form-label">Apellido</label>
          <input type="text" class="form-control" id="apellido" name="apellido" required>
        </div>
        <div class="mb-3">
          <label for="edad" class="form-label">Edad</label>
          <input type="number" class="form-control" id="edad" name="edad" required>
        </div>
        <div class="mb-3">
          <label for="telefono" class="form-label">Telefono</label>
          <input type="text" class="form-control" id="telefono" name="telefono">
        </div>
      </div>
    </div>

    <!-- Album de fotos -->
    <div class="card mb-4 shadow-sm">
      <div class="card-header bg-success text-white">Album de Fotos</div>
      <div class="card-body">
        <div class="drag-area" id="dragArea">
          Arrastra fotos aqui o haz click para seleccionar
          <input type="file" id="fotoInput" name="fotos[]" multiple hidden accept="image/*">
        </div>
        <div id="preview" class="d-flex flex-wrap"></div>
      </div>
    </div>

    <!-- Notas por sesion -->
    <div class="card mb-4 shadow-sm">
      <div class="card-header bg-warning text-dark">Notas por Sesion</div>
      <div class="card-body" id="sesionesContainer">
        <div class="session mb-3">
          <label class="form-label">Sesion 01</label>
          <textarea class="form-control mb-2" name="nota_sesion[]" placeholder="Escribe la nota aqui"></textarea>
        </div>
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

dragArea.addEventListener('dragover', e=>{
  e.preventDefault();
  dragArea.classList.add('dragover');
});

dragArea.addEventListener('dragleave', e=>{
  dragArea.classList.remove('dragover');
});

dragArea.addEventListener('drop', e=>{
  e.preventDefault();
  dragArea.classList.remove('dragover');
  const files = e.dataTransfer.files;
  handleFiles(files);
});

fotoInput.addEventListener('change', ()=>{
  handleFiles(fotoInput.files);
});

function handleFiles(files){
  preview.innerHTML = '';
  for(let i=0; i<files.length; i++){
    const reader = new FileReader();
    reader.onload = e=>{
      const img = document.createElement('img');
      img.src = e.target.result;
      img.classList.add('preview-img');
      preview.appendChild(img);
    }
    reader.readAsDataURL(files[i]);
  }
}

// Agregar sesiones dinamicamente
document.getElementById('addSesion').addEventListener('click', ()=>{
  const container = document.getElementById('sesionesContainer');
  const count = container.querySelectorAll('.session').length + 1;
  const div = document.createElement('div');
  div.classList.add('session', 'mb-3');
  div.innerHTML = `<label class="form-label">Sesion ${count}</label>
                   <textarea class="form-control mb-2" name="nota_sesion[]" placeholder="Escribe la nota aqui"></textarea>`;
  container.appendChild(div);
});
</script>

</body>
</html>

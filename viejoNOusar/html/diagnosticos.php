<?php
session_start();
if(!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] != 'medico'){
    header("Location: login.php");
    exit;
}

$medico_id = $_SESSION['usuario_id'];
$conn = new mysqli("localhost","root","","clinica");
if($conn->connect_error) die("Conexion fallida: ".$conn->connect_error);

// Guardar nuevo diagnóstico
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $cita_id     = intval($_POST['cita_id']);
    $diagnostico = isset($_POST['diagnostico']) ? trim($_POST['diagnostico']) : '';
    $tratamiento = isset($_POST['tratamiento']) ? trim($_POST['tratamiento']) : '';

    // Validación básica
    if($diagnostico === ''){
        die("❌ El diagnóstico es obligatorio.");
    }

    // Obtener paciente_id desde la cita
    $sql = "SELECT paciente_id, fecha FROM citas WHERE id = ?";
    $stmtCita = $conn->prepare($sql);
    $stmtCita->bind_param("i", $cita_id);
    $stmtCita->execute();
    $stmtCita->bind_result($paciente_id, $fecha_cita);
    $stmtCita->fetch();
    $stmtCita->close();

    if(!$paciente_id){
        die("❌ La cita seleccionada no es válida.");
    }

    // Usa la fecha de la cita o la fecha actual
    $fecha = $fecha_cita ?: date('Y-m-d');

    // Manejo de la imagen subida (opcional)
    $rutaImagen = null;
    if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE){
        if($_FILES['imagen']['error'] === UPLOAD_ERR_OK){
            // Validación simple de imagen
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime  = finfo_file($finfo, $_FILES['imagen']['tmp_name']);
            finfo_close($finfo);

            $extPermitidas = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];
            if(!isset($extPermitidas[$mime])){
                die("❌ Formato de imagen no permitido. Usa JPG, PNG, GIF o WEBP.");
            }

            // Carpeta de subida
            $dir = __DIR__ . "/uploads/diagnosticos/";
            if(!is_dir($dir)) mkdir($dir, 0777, true);

            $ext = $extPermitidas[$mime];
            $nombreArchivo = time() . "_" . bin2hex(random_bytes(4)) . "." . $ext;
            $rutaFS  = $dir . $nombreArchivo;                // ruta física
            $rutaURL = "uploads/diagnosticos/" . $nombreArchivo; // ruta relativa para <img>

            if(!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaFS)){
                die("❌ No se pudo guardar la imagen.");
            }
            $rutaImagen = $rutaURL;
        } else {
            die("❌ Error al subir la imagen (código {$_FILES['imagen']['error']}).");
        }
    }

    // Guardar diagnostico
    $stmt = $conn->prepare("INSERT INTO diagnosticos (cita_id, paciente_id, medico_id, fecha, diagnostico, tratamiento, imagen) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiissss", $cita_id, $paciente_id, $medico_id, $fecha, $diagnostico, $tratamiento, $rutaImagen);
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Diagnósticos</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>🩺 Diagnósticos</h3>
    <a href="panel_medico.php" class="btn btn-secondary mb-3">Volver al Panel</a>

    <h5>Registrar Diagnóstico</h5>
    <!-- IMPORTANTE: enctype para subir archivos -->
    <form method="POST" class="mb-4" enctype="multipart/form-data">
        <div class="mb-2">
            <label>Paciente / Motivo</label>
            <select name="cita_id" class="form-select" required>
                <?php
                $sql = "SELECT c.id, c.motivo, p.nombre, p.apellido1 
                        FROM citas c
                        JOIN pacientes p ON c.paciente_id=p.id
                        WHERE c.medico_id = ?
                        ORDER BY c.fecha DESC, c.hora DESC";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $medico_id);
                $stmt->execute();
                $res = $stmt->get_result();
                while($c = $res->fetch_assoc()){
                    echo "<option value='{$c['id']}'>" .
                            htmlspecialchars($c['nombre'] . ' ' . $c['apellido1'] . ' — ' . $c['motivo']) .
                         "</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-2">
            <label>Diagnóstico</label>
            <textarea name="diagnostico" class="form-control" required></textarea>
        </div>

        <div class="mb-2">
            <label>Tratamiento</label>
            <textarea name="tratamiento" class="form-control"></textarea>
        </div>

        <!-- Drag & Drop de imagen -->
        <div class="mb-2">
            <label>Subir Imagen (Opcional)</label>
            <div id="drop-area" class="border border-primary p-3 text-center bg-white" style="cursor:pointer;">
                Arrastra y suelta una imagen aquí o haz click para agregar un archivo.
            </div>
            <input type="file" id="fileElem" name="imagen" accept="image/*" style="display:none">
            <div id="preview" class="mt-2"></div>
        </div>

        <button type="submit" class="btn btn-success">Guardar Diagnóstico</button>
    </form>
    <!-- Script para Drag & Drop -->
    <script>
    let dropArea = document.getElementById("drop-area");
    let fileInput = document.getElementById("fileElem");
    let preview = document.getElementById("preview");

    dropArea.addEventListener("click", () => fileInput.click());

    ['dragenter','dragover','dragleave','drop'].forEach(eventName => {
      dropArea.addEventListener(eventName, e => e.preventDefault(), false)
    });

    dropArea.addEventListener("drop", e => {
      let file = e.dataTransfer.files[0];
      fileInput.files = e.dataTransfer.files;
      previewFile(file);
    });

    fileInput.addEventListener("change", () => {
      let file = fileInput.files[0];
      previewFile(file);
    });

    function previewFile(file) {
      if(!file) return;
      let reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onloadend = () => {
        preview.innerHTML = `<img src="${reader.result}" class="img-thumbnail mt-2" style="max-height:200px;">`;
      }
    }
    </script>

    <!-- Consulta de diagnosticos -->
    <h5>Mis Diagnósticos</h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Paciente</th>
                <th>Fecha</th>
                <th>Diagnóstico</th>
                <th>Imagen</th>
                <th>Tratamiento</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $conn->prepare("
                SELECT d.*, p.nombre AS paciente, p.apellido1
                FROM diagnosticos d
                JOIN pacientes p ON d.paciente_id = p.id
                WHERE d.medico_id = ?
                ORDER BY d.fecha DESC, d.id DESC
            ");
            $stmt->bind_param("i",$medico_id);
            $stmt->execute();
            $res = $stmt->get_result();
            while($row = $res->fetch_assoc()){
                $pac = htmlspecialchars($row['paciente'] . ' ' . $row['apellido1']);
                $diag = nl2br(htmlspecialchars($row['diagnostico']));
                $trat = nl2br(htmlspecialchars($row['tratamiento']));
                $imgHtml = !empty($row['imagen'])
                    ? "<img src='".htmlspecialchars($row['imagen'])."' class='img-thumbnail' style='max-height:100px;'>"
                    : "Sin imagen";

                echo "<tr>
                        <td>{$pac}</td>
                        <td>{$row['fecha']}</td>
                        <td>{$diag}</td>
                        <td>{$imgHtml}</td>
                        <td>{$trat}</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
<?php $conn->close(); ?>

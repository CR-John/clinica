<h3>📅 Registrar Cita</h3>
<form action="guardar_cita.php" method="POST">
  <div class="mb-3">
    <label>Paciente</label>
    <select name="paciente_id" class="form-select" required>
      <?php
      $conn = new mysqli("localhost", "root", "", "clinica");
      $res = $conn->query("SELECT id, nombre, apellido1 FROM pacientes");
      while ($row = $res->fetch_assoc()) {
          echo "<option value='{$row['id']}'>{$row['nombre']} {$row['apellido1']}</option>";
      }
      $conn->close();
      ?>
    </select>
  </div>

  <div class="mb-3">
    <label>Médico</label>
    <select name="medico_id" class="form-select" required>
      <?php
      $conn = new mysqli("localhost", "root", "", "clinica");
      $res = $conn->query("SELECT id, nombre, apellido1, especialidad FROM medicos");
      while ($row = $res->fetch_assoc()) {
          echo "<option value='{$row['id']}'>Dr. {$row['nombre']} {$row['apellido1']} - {$row['especialidad']}</option>";
      }
      $conn->close();
      ?>
    </select>
  </div>

  <div class="mb-3">
    <label>Fecha</label>
    <input type="date" name="fecha" class="form-control" required>
  </div>

  <div class="mb-3">
    <label>Hora</label>
    <input type="time" name="hora" class="form-control" required>
  </div>

  <div class="mb-3">
    <label>Motivo</label>
    <textarea name="motivo" class="form-control"></textarea>
  </div>

  <button type="submit" class="btn btn-success">Agendar Cita</button>
</form>

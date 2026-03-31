// routes/pacientes.js
const express = require("express");
const path = require("path");
const fs = require("fs");

module.exports = (db, upload) => {
  const router = express.Router();

  // 🔹 Obtener todos los pacientes
  router.get("/", (req, res) => {
    db.all("SELECT * FROM pacientes ORDER BY nombre ASC", (err, rows) => {
      if (err) return res.status(500).json({ error: err.message });
      res.json(rows);
    });
  });

  // 🔹 Obtener un paciente por ID con imágenes y citas
  router.get("/:id", (req, res) => {
    const id = req.params.id;
    const queryPaciente = "SELECT * FROM pacientes WHERE id = ?";
    const queryImagenes = "SELECT * FROM imagenes WHERE paciente_id = ?";
    const queryCitas = "SELECT * FROM citas WHERE paciente_id = ?";

    db.get(queryPaciente, [id], (err, paciente) => {
      if (err || !paciente) return res.status(404).json({ error: "Paciente no encontrado" });

      db.all(queryImagenes, [id], (err, imagenes) => {
        if (err) return res.status(500).json({ error: err.message });

        db.all(queryCitas, [id], (err, citas) => {
          if (err) return res.status(500).json({ error: err.message });

          res.json({ paciente, imagenes, citas });
        });
      });
    });
  });

  // 🔹 Registrar un nuevo paciente
  router.post("/", (req, res) => {
    const { nombre, fechaIngreso, comentarios } = req.body;
    if (!nombre) return res.status(400).json({ error: "Nombre requerido" });

    const query = "INSERT INTO pacientes (nombre, fechaIngreso, comentarios) VALUES (?, ?, ?)";
    db.run(query, [nombre, fechaIngreso || new Date().toISOString(), comentarios || ""], function (err) {
      if (err) return res.status(500).json({ error: err.message });
      res.json({ id: this.lastID, nombre, fechaIngreso, comentarios });
    });
  });

  // 🔹 Subir imágenes del paciente
  router.post("/:id/imagenes", upload.array("imagenes", 5), (req, res) => {
    const id = req.params.id;
    const files = req.files;

    if (!files || files.length === 0) return res.status(400).json({ error: "No se enviaron imágenes" });

    const insert = db.prepare("INSERT INTO imagenes (paciente_id, ruta) VALUES (?, ?)");
    files.forEach((file) => {
      insert.run(id, file.path);
    });
    insert.finalize();

    res.json({ message: "Imágenes guardadas correctamente", archivos: files.map(f => f.filename) });
  });

  // 🔹 Actualizar datos del paciente
  router.put("/:id", (req, res) => {
    const id = req.params.id;
    const { nombre, comentarios } = req.body;
    const query = "UPDATE pacientes SET nombre = ?, comentarios = ? WHERE id = ?";
    db.run(query, [nombre, comentarios, id], function (err) {
      if (err) return res.status(500).json({ error: err.message });
      res.json({ message: "Paciente actualizado" });
    });
  });

  // 🔹 Eliminar paciente y sus datos relacionados
  router.delete("/:id", (req, res) => {
    const id = req.params.id;

    // Eliminar imágenes físicas del disco
    db.all("SELECT ruta FROM imagenes WHERE paciente_id = ?", [id], (err, rows) => {
      if (!err && rows.length > 0) {
        rows.forEach((row) => {
          if (fs.existsSync(row.ruta)) fs.unlinkSync(row.ruta);
        });
      }
    });

    // Borrar registros relacionados
    db.run("DELETE FROM imagenes WHERE paciente_id = ?", [id]);
    db.run("DELETE FROM citas WHERE paciente_id = ?", [id]);
    db.run("DELETE FROM pacientes WHERE id = ?", [id], function (err) {
      if (err) return res.status(500).json({ error: err.message });
      res.json({ message: "Paciente y datos asociados eliminados" });
    });
  });

  return router;
};

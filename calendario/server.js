// server.js
const express = require("express");
const multer = require("multer");
const path = require("path");
const sqlite3 = require("sqlite3").verbose();
const fs = require("fs");

const app = express();
const PORT = 3000;

// Middlewares
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static("public"));

// Configuracion de base de datos
const dbFile = path.join(__dirname, "db", "database.sqlite");
if (!fs.existsSync(dbFile)) fs.writeFileSync(dbFile, "");
const db = new sqlite3.Database(dbFile);

// Configuracion de uploads
const storage = multer.diskStorage({
  destination: (req, file, cb) => cb(null, "uploads/"),
  filename: (req, file, cb) => cb(null, Date.now() + path.extname(file.originalname))
});
const upload = multer({ storage });

// Creacion de tablas si no existen
db.serialize(() => {
  db.run(`CREATE TABLE IF NOT EXISTS pacientes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    fechaIngreso TEXT,
    comentarios TEXT
  )`);

  db.run(`CREATE TABLE IF NOT EXISTS imagenes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    paciente_id INTEGER,
    ruta TEXT,
    FOREIGN KEY(paciente_id) REFERENCES pacientes(id)
  )`);

  db.run(`CREATE TABLE IF NOT EXISTS citas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    paciente_id INTEGER,
    fecha TEXT,
    motivo TEXT,
    estado TEXT,
    FOREIGN KEY(paciente_id) REFERENCES pacientes(id)
  )`);
});

// Importar rutas
const pacientesRoutes = require("./routes/pacientes")(db, upload);
const citasRoutes = require("./routes/citas")(db);

app.use("/api/pacientes", pacientesRoutes);
app.use("/api/citas", citasRoutes);

// Arrancar servidor
app.listen(PORT, () => console.log(`Servidor activo en http://localhost:${PORT}`));

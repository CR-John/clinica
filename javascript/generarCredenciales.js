// js/generarCredenciales.js NO SE UTILIZA, ES SOLO UNA IDEA 

// Función que genera una contraseña segura aleatoria de longitud definida (por defecto 8 caracteres)
function generarContrasenaAleatoria(longitud = 8) {
  const caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@#$%&";
  let contrasena = "";
  for (let i = 0; i < longitud; i++) {
    contrasena += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
  }
  return contrasena;
}

// Función que devuelve el usuario basado en la cédula; puede incluir prefijos como "pac-" o "med-" si se desea
function generarUsuarioDesdeCedula(cedula) {
  return cedula.trim(); // Ejemplo: "123456789" → "123456789", pero puede convertirse en "pac-123456789"
}

// Módulo definido para pruebas: actualmente no está en uso dentro del sistema principal

// Genera credenciales de médico a partir de su cédula
function generarCredencialesMedico(cedula) {
  return {
    usuario: generarUsuarioDesdeCedula(cedula),
    contrasena: generarContrasenaAleatoria()
  };
}

// Genera credenciales de paciente a partir de su cédula
function generarCredencialesPaciente(cedula) {
  return {
    usuario: generarUsuarioDesdeCedula(cedula),
    contrasena: generarContrasenaAleatoria()
  };
}

Instrucciones para Laragon:

1. Copiar la carpeta 'clinica' en C:\laragon\www\
2. Iniciar Apache y MySQL desde Laragon
3. Crear la base de datos 'clinica'
4. Crear tabla 'pacientes' con columnas:
   - id (INT AUTO_INCREMENT PRIMARY KEY)
   - nombre (VARCHAR)
   - apellido (VARCHAR)
   - edad (INT)
   - telefono (VARCHAR)
5. Crear tabla 'notas' con columnas:
   - id (INT AUTO_INCREMENT PRIMARY KEY)
   - paciente_id (INT)
   - nota (TEXT)
6. Acceder desde navegador: http://localhost/clinica/html/Index.php
7. Carpeta 'uploads/' se llenara automaticamente con fotos de pacientes

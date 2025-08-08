CREATE TABLE recordatorio_medicamentos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre_usuario VARCHAR(100),
  edad VARCHAR(3),
  nombre_familiar VARCHAR(100),
  email_familiar VARCHAR(100),
  telefono_familiar VARCHAR(20),
  frecuencia_dosis  VARCHAR(50),
  comentario TEXT
);

-- inizializzazione e creazione tabella del db 
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50),
  password VARCHAR(50),
  email VARCHAR(100)
);

-- inserimento valori nella tabella
INSERT INTO users (username, password, email) VALUES
('admin', 'admin123', 'admin@example.com'),
('marirossi', 'pass1234', 'maria.rossi@example.it'),
('giovannib', 'securePwd1', 'giovanni.bianchi@example.it'),
('francescav', 'francy2025', 'francesca.verdi@example.it'),
('lorenzop', 'lorenzoPwd!', 'lorenzo.pagliuca@example.it'),
('alessandrac', 'alessandro99', 'alessandra.costa@example.it'),
('davidem', 'davideM2024', 'davide.marino@example.it'),
('giuliap', 'giuliaPwd22', 'giulia.palumbo@example.it'),
('andream', 'andreaPass1', 'andrea.mancini@example.it'),
('valentinag', 'valentinaG!', 'valentina.galli@example.it'),
('federicor', 'fedeRico2025', 'federico.rossi@example.it');


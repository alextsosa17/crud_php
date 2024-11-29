
CREATE DATABASE crud_php;

USE crud_php;


CREATE TABLE area (
    codigo_area INT(3) NOT NULL,
    PRIMARY KEY (codigo_area)
);

CREATE TABLE formulario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    documento VARCHAR(10) UNIQUE,
    codigo_area INT(3),
    telefono VARCHAR(8),
    email VARCHAR(100) UNIQUE,
    FOREIGN KEY (codigo_area) REFERENCES area(codigo_area)  
);


INSERT INTO area (codigo_area)
VALUES 
    (FLOOR(RAND() * 900) + 100),  -- Genera un número aleatorio entre 100 y 999
    (FLOOR(RAND() * 900) + 100),  -- Genera un número aleatorio entre 100 y 999
    (FLOOR(RAND() * 900) + 100),  -- Genera un número aleatorio entre 100 y 999
    (FLOOR(RAND() * 900) + 100),  -- Genera un número aleatorio entre 100 y 999
    (FLOOR(RAND() * 900) + 100),  -- Genera un número aleatorio entre 100 y 999
    (FLOOR(RAND() * 900) + 100),  -- Genera un número aleatorio entre 100 y 999
    (FLOOR(RAND() * 900) + 100),  -- Genera un número aleatorio entre 100 y 999
    (FLOOR(RAND() * 900) + 100),  -- Genera un número aleatorio entre 100 y 999
    (FLOOR(RAND() * 900) + 100),  -- Genera un número aleatorio entre 100 y 999
    (FLOOR(RAND() * 900) + 100);  -- Genera un número aleatorio entre 100 y 99
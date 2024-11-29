CREATE DATABASE crud_db;

USE crud_db;

CREATE TABLE area (
    codigo_area INT(3) NOT NULL,
    PRIMARY KEY (codigo_area)
);

CREATE TABLE formulario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    documento VARCHAR(10) UNIQUE,
    telefono_area INT(3),
    telefono VARCHAR(8),
    email VARCHAR(100) UNIQUE
);
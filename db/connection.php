<?php
$host = 'localhost'; // Cambia si es necesario
$dbname = 'crud_php';
$username = 'root'; // Cambia si es necesario
$password = ''; // Cambia si es necesario

// Crear conexión
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

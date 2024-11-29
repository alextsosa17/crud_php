<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<style>

.crud-buttons a {
    text-decoration: none; 
    display: inline-block; 
    margin: 5px; 
}

.crud-btn {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%; 
}

.crud-btn:hover {
    background-color: #0056b3;
}

@media (max-width: 480px) {
    .crud-btn {
        font-size: 14px;
        padding: 8px 15px;
    }
}
/* Header Style */
.header {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
    text-align: center; /* Centra el texto */
}

</style>
<body>
    <!-- Botones para las operaciones CRUD -->
    <div class="crud-buttons">
        <h2 class="header">Crud PHP - Prueba Técnica</h2>
        <a href="create.php" class="header-button"><button class="crud-btn">Crear Registro</button></a>
        <a href="list.php" class="header-button"><button class="crud-btn">Listar Registros</button></a>
    </div>
    <br><!-- le doy un espacio para que quede mas prolijo el espaciado del -->


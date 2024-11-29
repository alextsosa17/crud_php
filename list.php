<?php
include_once('db/connection.php');
include_once('includes/functions.php');
include_once('header.php'); 
session_start();

// Mostrar mensaje de éxito o error si existe
if (isset($_SESSION['flash_message'])) {
    
    $flash_message = $_SESSION['flash_message'];
    
    if ($flash_message['type'] == 'success') {
        $alert_style = 'background-color: #4CAF50; color: white; padding: 15px; border-radius: 5px; font-size: 16px; width: 30%; margin: 20px auto; text-align: center;';
    } elseif ($flash_message['type'] == 'error') {
        $alert_style = 'background-color: #f44336; color: white; padding: 15px; border-radius: 5px; font-size: 16px; width: 30%; margin: 20px auto; text-align: center;';
    } else {
        $alert_style = 'background-color: #2196F3; color: white; padding: 15px; border-radius: 5px; font-size: 16px; width: 30%; margin: 20px auto; text-align: center;';
    }
    
    echo '<div style="' . $alert_style . '">' . $flash_message['message'] . '</div>';
    // Eliminar el mensaje para el próximo ciclo
    unset($_SESSION['flash_message']);
}

$datos = get_datos(); // Llamada a la función que obtiene los datos
?>

<style>
/* Estilos para la tabla y botones */
.table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
}

.table th,
.table td {
    padding: 12px;
    text-align: left;
    border: 1px solid #ddd;
}

.table th {
    background-color: #007bff;
    color: white;
}

.table tr:nth-child(even) {
    background-color: #f2f2f2;
}

.table tr:hover {
    background-color: #ddd;
}

.btn {
    padding: 8px 12px;
    border-radius: 4px;
    color: white;
    text-decoration: none;
    font-weight: bold;
    margin-right: 8px;
}

.btn-edit {
    background-color: #007bff;
}

.btn-edit:hover {
    background-color: #0056b3;
}

.btn-delete {
    background-color: #e74c3c;
}

.btn-delete:hover {
    background-color: #c0392b;
}
</style>
<script src="assets/js/validacion.js"></script>
<body class="body">
    <div class="container">
        <h3>Listado de Registros</h3>

        <?php if (empty($datos)): ?>
            <!-- Mensaje si no hay datos -->
            <div style="background-color: #f44336; color: white; padding: 15px; border-radius: 5px; font-size: 16px; width: 60%; margin: 20px auto; text-align: center;">
                Por favor ingrese algún dato en <strong>Crear Registro</strong>para poder visualizarlos.
            </div>
        <?php else: ?>
            <!-- Tabla con datos -->
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Documento</th>
                        <th>Código de Área</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos as $dato): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($dato['id']); ?></td>
                        <td><?php echo htmlspecialchars($dato['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($dato['apellido']); ?></td>
                        <td><?php echo htmlspecialchars($dato['documento']); ?></td>
                        <td><?php echo htmlspecialchars($dato['codigo_area']); ?></td>
                        <td><?php echo htmlspecialchars($dato['telefono']); ?></td>
                        <td><?php echo htmlspecialchars($dato['email']); ?></td>
                        <td>
                            <!-- Formulario para editar -->
                            <form action="crud.php" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="editar">
                                <input type="hidden" name="id" value="<?php echo $dato['id']; ?>">
                                <input type="hidden" name="nombre" value="<?php echo $dato['nombre']; ?>">
                                <input type="hidden" name="apellido" value="<?php echo $dato['apellido']; ?>">
                                <input type="hidden" name="documento" value="<?php echo $dato['documento']; ?>">
                                <input type="hidden" name="telefono" value="<?php echo $dato['telefono']; ?>">
                                <input type="hidden" name="email" value="<?php echo $dato['email']; ?>">
                                <input type="hidden" name="codigo_area" value="<?php echo $dato['codigo_area']; ?>">
                                <button type="submit" class="btn btn-edit">Editar</button>
                            </form>

                            <!-- Formulario para eliminar -->
                            <form action="crud.php" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="eliminar">
                                <input type="hidden" name="id" value="<?php echo $dato['id']; ?>">
                                <button type="submit" class="btn btn-delete">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>


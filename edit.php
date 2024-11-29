<?php
// Incluir archivos de conexión y funciones
include_once('db/connection.php');
include_once('includes/functions.php');
include_once('header.php');

// Verificar si se ha pasado un ID en la URL
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Obtener el ID desde la URL
    
    // Llamada a la función que obtiene los datos del registro por ID
    $datos = get_datos_by_id($id); // Asumiendo que tienes esta función definida
    
    // Si no se encuentran los datos, redirigir al listado
    if (!$datos) {
        header("Location: list.php");
        exit();
    }
} else {
    // Si no se pasa el ID, redirigir al listado
    header("Location: list.php");
    exit();
}
?>

<style>
    /* Estilos para la tabla */
    .table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }

    .table th, .table td {
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

    .btn-save {
        background-color: #28a745;
    }

    .btn-save:hover {
        background-color: #218838;
    }

    .btn-cancel {
        background-color: #e0a800;
    }

    .btn-cancel:hover {
        background-color: #d39e00;
    }

    .input-field {
        padding: 8px;
        width: 100%;
        margin: 5px 0;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

</style>

<body class="body">
    <div class="container">
        <form method="POST" action="crud.php" id="myForm">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($datos['id']); ?>" />
            <input type="hidden" name="action" value="update" /> <!-- Acción editar -->
            <table class="table">
                <thead>
                    <tr>
                        <th>Campo</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ID</td>
                        <td><input type="text" name="id" class="input-field" value="<?php echo htmlspecialchars($datos['id']); ?>" readonly /></td>
                    </tr>
                    <tr>
                        <td>Nombre</td>
                        <td><input type="text" name="nombre" class="input-field nombre" value="<?php echo htmlspecialchars($datos['nombre']); ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Apellido</td>
                        <td><input type="text" name="apellido" class="input-field apellido" value="<?php echo htmlspecialchars($datos['apellido']); ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Documento</td>
                        <td><input type="text" name="documento" class="input-field documento" value="<?php echo htmlspecialchars($datos['documento']); ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Código de Área</td>
                        <td><input type="text" name="codigo_area" class="input-field codigo-area" value="<?php echo htmlspecialchars($datos['codigo_area']); ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Teléfono</td>
                        <td><input type="text" name="telefono" class="input-field telefono" value="<?php echo htmlspecialchars($datos['telefono']); ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><input type="email" name="email" class="input-field email" value="<?php echo htmlspecialchars($datos['email']); ?>" required /></td>
                    </tr>
                </tbody>
            </table>
            <div>
                <button type="submit" class="btn btn-save">Guardar Cambios</button>
                <a href="list.php" class="btn btn-cancel">Cancelar</a>
            </div>
        </form>
    </div>
</body>

<script>
    document.getElementById("myForm").onsubmit = function(event) {
        // Obtener valores de los campos
        let nombre = document.querySelector(".nombre").value;
        let apellido = document.querySelector(".apellido").value;
        let documento = document.querySelector(".documento").value;
        let email = document.querySelector(".email").value;
        let telefono = document.querySelector(".telefono").value;
        let codigo_area = document.querySelector(".codigo-area").value;

        // Expresiones regulares para validaciones
        let regex_nombre_apellido = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ' ]+$/; // letras, acentos, ñ y apóstrofes
        let regex_documento = /^\d{1,10}$/; // solo números, hasta 10 dígitos
        let regex_telefono = /^\d{8,}$/; // teléfono con mínimo 8 dígitos
        let regex_email = /^[a-z0-9_.-]+@[a-z0-9.-]+\.[a-z]{2,3}$/; // Email en minúsculas y formato correcto
        let regex_codigo_area = /^\d{3}$/; // Código de área con 3 dígitos

        // Validación del nombre y apellido
        if (!nombre.match(regex_nombre_apellido) || !apellido.match(regex_nombre_apellido)) {
            alert("El nombre o el apellido no es válido. Caracteres permitidos: letras, acentos, ñ y apóstrofes.");
            event.preventDefault();
            return false;
        }

        // Validación del documento
        if (!documento.match(regex_documento)) {
            alert("El documento no es válido. Solo números, hasta 10 dígitos.");
            event.preventDefault();
            return false;
        }

        // Validación del teléfono
        if (!codigo_area.match(regex_codigo_area) || isNaN(codigo_area)) {
            alert("El código de área debe tener 3 dígitos.");
            event.preventDefault();
            return false;
        }

        if (!telefono.match(regex_telefono)) {
            alert("El teléfono debe tener al menos 8 dígitos.");
            event.preventDefault();
            return false;
        }

        // Validación del email
        if (!email.match(regex_email)) {
            alert(
                "El correo electrónico no es válido. Asegúrese de que el formato sea correcto y que el correo esté en minúsculas.");
            event.preventDefault();
            return false;
        }
    };
</script>

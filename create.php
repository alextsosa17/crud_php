<?php
include_once('includes/functions.php');
include_once('db/connection.php');
include_once('header.php'); 
session_start();

//cartel de errores o exito de insert o codigo de area no correspondiente que se valida en el "back"

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
        //elimino el mensaje para el proximo ciclo 
        unset($_SESSION['flash_message']);
    }
    
$campos = obtener_campos();
//solamente listo los campos que necesito para
$tipos = [
    "email" => "email",
    "documento" => "number",
    "telefono" => "number",  // Este campo se manejará desde JavaScript
    "codigo_area" => "number"   
];


?>
<script src="assets/js/validacion.js"></script>
<body class="body">
    <form action="crud.php" method="POST" id="myForm" class="form-container">
    <input type="hidden" name="action" id="action" value="guardar"> <!-- Campo oculto para la acción -->
        <?php foreach ($campos as $campo): 
            $tipo_input = "text";

            if (array_key_exists($campo, $tipos)) {
                $tipo_input = $tipos[$campo];
            }
        ?>
        <div class="form-group">
            <label for="<?= $campo ?>" class="form-label"><?= ucfirst(str_replace("_", " ", $campo)) ?>:</label>
            <?php if ($campo == 'telefono') { ?>
            <div class="form-telefono">
                <input type="number" name="codigo_area" class="codigo-area form-input" required
                    placeholder="Código de área (3 dígitos)" maxlength="3">
                <input type="number" name="telefono" class="telefono form-input" required
                    placeholder="Teléfono (mín. 8 dígitos)" minlength="8">
            </div>
            <?php } else { ?>
            <input type="<?= $tipo_input ?>" name="<?= $campo ?>" class="<?= $campo ?> form-input" required
                placeholder="Ingrese <?= strtolower(str_replace('_', ' ', $campo)) ?>" />
            <?php } ?>
        </div>
        <?php endforeach; ?>
        <button type="submit" class="form-button" >Guardar</button>
    </form>

 

</body>

</html>

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

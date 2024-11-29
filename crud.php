<?php
include_once('includes/functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'guardar':
            case 'update': // Usamos la misma función para guardar o editar
                    $id = isset($_POST['id']) ? $_POST['id'] : null; // Solo en 'editar' se usará el id
                    $nombre = $_POST['nombre'];
                    $apellido = $_POST['apellido'];
                    $documento = $_POST['documento'];
                    $telefono = $_POST['telefono'];
                    $email = $_POST['email'];
                    $codigo_area = $_POST['codigo_area'];
                    //si es update el codigo de area va a ser siempre valido pero para no repetir codigo lo arme aca.
                    if (validar_codigo_area($codigo_area)) {
                        guardar_o_editar_datos($id, $nombre, $apellido, $documento, $codigo_area, $telefono, $email);
                    } else {
                        redirigir_con_error('Código de área no existente', $_POST['action']);
                    }
                    break;
    
               case 'editar':
                    $id = $_POST['id']; // Obtén el ID del registro a editar
                    header("Location: edit.php?id=$id"); // Redirige a edit.php pasando el ID como parámetro
                    exit();
                    break;

             case 'eliminar':
                 // Obtener el ID del registro a eliminar
                 $id = $_POST['id']; // Asegúrate de enviar este campo desde el formulario de eliminación
                 eliminar_datos($id);
                 break;
            case 'listar':
                // Listar datos
                $datos = get_datos(); // Mostrar todos los datos
                break;
          
            default:
                echo "Acción no válida.";
                break;
        }
    }
}
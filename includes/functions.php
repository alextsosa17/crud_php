<?php
include_once('db/connection.php');

function obtener_campos() {
    global $conn;

    $result = $conn->query("SHOW COLUMNS FROM formulario");

    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }

    $campos = [];
    while ($row = $result->fetch_assoc()) {
        if ($row['Field'] !== 'id' && $row['Field'] !== 'codigo_area') {
            $campos[] = $row['Field'];
        }
    }

    return $campos;
}

function validar_email($email, $id = null) {
    global $conn;

    $sql = "SELECT COUNT(*) FROM formulario WHERE email = ?";
    if ($id) {
        $sql .= " AND id != ?";
    }

    $stmt = $conn->prepare($sql);
    if ($id) {
        $stmt->bind_param("si", $email, $id);
    } else {
        $stmt->bind_param("s", $email);
    }
    $stmt->execute();
    $stmt->bind_result($email_count);
    $stmt->fetch();
    $stmt->close();

    return $email_count == 0;
}

function validar_documento($documento, $id = null) {
    global $conn;

    $sql = "SELECT COUNT(*) FROM formulario WHERE documento = ?";
    if ($id) {
        $sql .= " AND id != ?";
    }

    $stmt = $conn->prepare($sql);
    if ($id) {
        $stmt->bind_param("si", $documento, $id);
    } else {
        $stmt->bind_param("s", $documento);
    }
    $stmt->execute();
    $stmt->bind_result($documento_count);
    $stmt->fetch();
    $stmt->close();

    return $documento_count == 0;
}

function validar_telefono($telefono, $id = null) {
    global $conn;

    $sql = "SELECT COUNT(*) FROM formulario WHERE telefono = ?";
    if ($id) {
        $sql .= " AND id != ?";
    }

    $stmt = $conn->prepare($sql);
    if ($id) {
        $stmt->bind_param("si", $telefono, $id);
    } else {
        $stmt->bind_param("s", $telefono);
    }
    $stmt->execute();
    $stmt->bind_result($telefono_count);
    $stmt->fetch();
    $stmt->close();

    return $telefono_count == 0;
}

function validar_codigo_area($codigo_area) {
    global $conn;

    if (!is_numeric($codigo_area)) {
        return false;
    }

    $stmt = $conn->prepare("SELECT COUNT(*) FROM area WHERE codigo_area = ?");
    $stmt->bind_param("i", $codigo_area);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    return $count > 0;
}

function get_datos() {
    global $conn;

    $sql = "SELECT * FROM formulario";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $datos = [];

        while ($row = $result->fetch_assoc()) {
            $datos[] = $row;
        }

        return $datos;
    } else {
        return [];
    }
}

function redirigir_con_error($mensaje, $vista) {
    $url = ($vista === 'guardar') ? 'create.php' : (($vista === 'update') ? 'list.php' : 'index.php');
    session_start();
    
    $_SESSION['flash_message'] = [
        'type' => 'error',
        'message' => $mensaje
    ];

    header("Location: $url");
    exit();
}

function guardar_datos($nombre, $apellido, $documento, $codigo_area, $telefono, $email) {
    global $conn;
    session_start();

    // Validaciones
    if (!validar_email($email)) {
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'message' => 'El email ya está registrado.'
        ];
        header('Location: create.php');
        exit;
    }

    if (!validar_documento($documento)) {
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'message' => 'El documento ya está registrado.'
        ];
        header('Location: create.php');
        exit;
    }

    if (!validar_telefono($telefono)) {
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'message' => 'El teléfono ya está registrado.'
        ];
        header('Location: create.php');
        exit;
    }

    $sql = "INSERT INTO formulario (nombre, apellido, documento, codigo_area, telefono, email) 
            VALUES ('$nombre', '$apellido', '$documento', '$codigo_area', '$telefono', '$email')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => 'Datos ingresados correctamente.'
        ];
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'message' => 'Hubo un error al ingresar los datos.'
        ];
    }

    header('Location: create.php');
    exit;
}

function actualizar_datos($id, $nombre, $apellido, $documento, $codigo_area, $telefono, $email) {
    global $conn;
    session_start();

    // Validaciones
    if (!validar_email($email, $id)) {
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'message' => 'El email ya está registrado.'
        ];
        header('Location: list.php');
        exit;
    }

    if (!validar_documento($documento, $id)) {
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'message' => 'El documento ya está registrado.'
        ];
        header('Location: list.php');
        exit;
    }

    if (!validar_telefono($telefono, $id)) {
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'message' => 'El teléfono ya está registrado.'
        ];
        header('Location: list.php');
        exit;
    }

    if ($id) {
        $sql = "UPDATE formulario SET 
                    nombre = ?, 
                    apellido = ?, 
                    documento = ?, 
                    codigo_area = ?, 
                    telefono = ?, 
                    email = ? 
                WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $nombre, $apellido, $documento, $codigo_area, $telefono, $email, $id);

        if ($stmt->execute()) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Datos actualizados correctamente.'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'Hubo un error al actualizar los datos.'
            ];
        }
        $stmt->close();
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'message' => 'No se ha encontrado el registro a actualizar.'
        ];
    }

    header('Location: list.php');
    exit;
}

function guardar_o_editar_datos($id, $nombre, $apellido, $documento, $codigo_area, $telefono, $email) {
    if ($id) {
        actualizar_datos($id, $nombre, $apellido, $documento, $codigo_area, $telefono, $email);
    } else {
        guardar_datos($nombre, $apellido, $documento, $codigo_area, $telefono, $email);
    }
}

function get_datos_by_id($id) {
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);

    $sql = "SELECT * FROM formulario WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return null;
    }
}

function eliminar_datos($id) {
    global $conn;
    session_start();

    $id = mysqli_real_escape_string($conn, $id);

    $sql = "DELETE FROM formulario WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => 'Registro eliminado correctamente.'
        ];
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'message' => 'Hubo un error al eliminar el registro.'
        ];
    }

    header('Location: list.php');
    exit;
}
?>

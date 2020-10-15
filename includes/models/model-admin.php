<?php
$action = $_POST['action'];
$password = $_POST['password'];
$usuario = $_POST['usuario'];

if ($action === 'crear') {
    $options = array(
        'cost' => 10
    );
    $hash_password = password_hash($password, PASSWORD_BCRYPT, $options);
    //Importar conexión.
    include '../functions/connection.php';

    try {
        $stmt = $conn->prepare("INSERT INTO usuarios (usuario, password) values (?, ?)");
        $stmt->bind_param('ss', $usuario, $hash_password);
        // $val = $stmt->execute();
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $response = array(
                'respuesta' => 'Correcto',
                'id_insertado' => $stmt->insert_id,
                'error' => $stmt->error,
                // 'bool' => $val,
                'tipo' => $action
            );
        } else {
            $response = array(
                'respuesta' => 'Incorrecto',
                // 'respuesta' => $stmt->error_list,
                'error' => $stmt->error,
                'tipo' => $action
            );
        }

        $stmt->close();
        $conn->close();
    } catch (\Exception $e) {
        $response = array(
            'error' => $e->getMessage()
        );
    }

    echo json_encode($response);
}

if ($action === 'login') {
    include '../functions/connection.php';
    try {
        // Selecciona el admin de la bd.
        $stmt = $conn->prepare("SELECT id, usuario, password FROM usuarios WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        // Loguear usuario
        $stmt->bind_result($id_usuario, $nombre_usuario, $password_usuario);
        $stmt->fetch();
        if ($nombre_usuario) {
            //Existe, verificar password.
            if (password_verify($password, $password_usuario)) {
                //Iniciar session
                session_start();
                $_SESSION['nombre'] = $nombre_usuario;
                $_SESSION['id'] = $id_usuario;
                $_SESSION['login'] = true;
                //Login Correcto
                $response = array(
                    'respuesta' => 'Correcto',
                    'tipo' => $action,
                    'nombre' => $nombre_usuario
                );
            } else {
                $response = array(
                    'respuesta' => 'Incorrecto'
                );
            }
        } else {
            $response = array(
                'respuesta' => 'Incorrecto'
            );
        }
        
        $stmt->close();
        $conn->close();
    } catch (\Exception $e) {
        $response = array(
            'respuesta' => 'error',
            'msj' => $e->getMessage()
        );
    }
    echo json_encode($response);
}
// $arreglo = array(
//     'respuesta' => 'Desde Model!'
// );
// // die(json_encode($arreglo));
// die(json_encode($_POST));
<?php

// echo json_encode($_POST);
$id = isset($_POST['id']) ? $_POST['id'] : "";
$proyecto = isset($_POST['proyecto']) ? $_POST['proyecto'] : "";
$usuarioId = isset($_POST['usuarioId']) ? $_POST['usuarioId'] : "";
$action = $_POST['action'];

if ($action === 'crear') {
    
    //Importar conexión.
    include '../functions/connection.php';

    try {
        $stmt = $conn->prepare("INSERT INTO proyectos (nombre, usuarioId) values (?, ?)");
        $stmt->bind_param('si', $proyecto, $usuarioId);
        $stmt->execute();
        if ($stmt->affected_rows) {
            $response = array(
                'respuesta' => 'Correcto',
                'id_proyecto' => $stmt->insert_id,
                'accion' => $action,
                'nombre_proyecto' => $proyecto
            );
        } else {
            $response = array(
                'respuesta' => $stmt->error_list,
                'error' => $stmt->error
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
if ($action === 'actualizar') {
    
    //Importar conexión.
    include '../functions/connection.php';

    try {
        $stmt = $conn->prepare("UPDATE proyectos SET nombre = ? WHERE idProyecto = ?");
        $stmt->bind_param('si', $proyecto, $id);
        $stmt->execute();
        if ($stmt->affected_rows) {
            $response = array(
                'respuesta' => 'Correcto',
                'id_proyecto' => $stmt->insert_id,
                'accion' => $action,
                'nombre_proyecto' => $proyecto
            );
        } else {
            $response = array(
                'respuesta' => $stmt->error_list,
                'error' => $stmt->error
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
if ($action === 'eliminar') {
    
    //Importar conexión.
    include '../functions/connection.php';

    try {
        $stmt = $conn->prepare("DELETE FROM proyectos WHERE idProyecto = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        if ($stmt->affected_rows) {
            $response = array(
                'respuesta' => 'Correcto',
                'id_proyecto' => $stmt->insert_id,
                'accion' => $action,
                'nombre_proyecto' => $proyecto
            );
        } else {
            $response = array(
                'respuesta' => $stmt->error_list,
                'error' => $stmt->error
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
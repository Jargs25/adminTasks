<?php
// echo json_encode($_POST);
$action = $_POST['action'];
$id_proyecto = isset($_POST['id_proyecto'])?(int) $_POST['id_proyecto']:0;
$tarea = isset($_POST['tarea'])?$_POST['tarea']:"";
$estado = isset($_POST['estado']) ? $_POST['estado'] : "";
$id_tarea = isset($_POST['id']) ? (int) $_POST['id'] : "";

if ($action === 'crear') {
    
    //Importar conexión.
    include '../functions/connection.php';

    try {
        $stmt = $conn->prepare("INSERT INTO tareas (nombre, proyectoId) values (?, ?)");
        $stmt->bind_param('si', $tarea, $id_proyecto);
        $stmt->execute();
        if ($stmt->affected_rows) {
            $response = array(
                'respuesta' => 'Correcto',
                'id_insertado' => $stmt->insert_id,
                'accion' => $action,
                'tarea' => $tarea
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
    // echo json_encode($_POST); 
      
    //Importar conexión.
    include '../functions/connection.php';

    try {
        $stmt = $conn->prepare("UPDATE tareas SET estado = ? WHERE idTarea = ?");
        $stmt->bind_param('ii', $estado, $id_tarea);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $response = array(
                'respuesta' => 'Correcto'
            );
        } else {
            $response = array(
                'respuesta' => 'error',
                'mensaje' => $stmt->error_list,
                'error' => $stmt->error
            );
        }

        $stmt->close();
        $conn->close();
    } catch (\Throwable $e) {
        $response = array(
            'error' => $e->getMessage()
        );
    }

    echo json_encode($response);
}

if ($action === 'eliminar') {
    // echo json_encode($_POST); 
      
    //Importar conexión.
    include '../functions/connection.php';

    try {
        $stmt = $conn->prepare("DELETE FROM tareas WHERE idTarea = ?");
        $stmt->bind_param('i', $id_tarea);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $response = array(
                'respuesta' => 'Correcto'
            );
        } else {
            $response = array(
                'respuesta' => 'error',
                'mensaje' => $stmt->error_list,
                'error' => $stmt->error
            );
        }

        $stmt->close();
        $conn->close();
    } catch (\Throwable $e) {
        $response = array(
            'error' => $e->getMessage()
        );
    }

    echo json_encode($response);
}
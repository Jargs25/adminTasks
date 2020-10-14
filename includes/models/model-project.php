<?php

// echo json_encode($_POST);
$action = $_POST['action'];
$proyecto = $_POST['proyecto'];

if ($action === 'crear') {
    
    //Importar conexión.
    include '../functions/connection.php';

    try {
        $stmt = $conn->prepare("INSERT INTO proyectos (nombre) values (?)");
        $stmt->bind_param('s', $proyecto);
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
<?php

function getCurrentPage(){
    $page = basename($_SERVER['PHP_SELF']);
    $class = str_replace(".php","",$page);
    return $class;
}

// Consultas


function getProjects()
{
    include 'connection.php';
    try {
        return $conn->query('SELECT idProyecto, nombre FROM proyectos');
    } catch (\Exception $e) {
        echo "Error!: ".$e->getMessage();
        return false;
    }
}

function getProjectName($id = null){
    include 'connection.php';

    try {
        return $conn->query("SELECT nombre FROM proyectos WHERE idProyecto = {$id}");
    } catch (\Exception $e) {
        echo "Error!: ".$e->getMessage();
        return false;
    }
}

function getTasks($id = null)
{
    include 'connection.php';

    try {
        return $conn->query("SELECT idTarea, nombre, estado FROM tareas WHERE proyectoId = {$id}");
    } catch (\Exception $e) {
        echo "Error!: ".$e->getMessage();
        return false;
    }
}
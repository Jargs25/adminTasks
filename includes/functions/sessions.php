<?php

function usuario_autentificado(){
    if (!revisar_usuario()) {//Verifica si existe un logueado.
        header('Location: login.php');
        exit();
    }
}

function revisar_usuario()
{
    return isset($_SESSION['nombre']);
}
session_start();//Permite iniciar la sesion.
usuario_autentificado();
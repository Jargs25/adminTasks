<?php 
    include 'includes/functions/functions.php';
    include 'includes/template/header.php';

    //session_start(); //Necesario para ver la info de la session.
    // echo "<pre>";
    // var_dump($_SESSION);
    // echo "</pre>";
    // if (isset($_GET['cerrar_session'])) {
    //     $_SESSION = array();
    // }
?>

<div class="contenedor-formulario">
    <h1>UpTask</h1>
    <form id="formulario" class="caja-login" method="post">
        <h2>Iniciar Sesión</h2>
        <div class="campo">
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" placeholder="Usuario">
        </div>
        <div class="campo">
            <label for="password">Password: </label>
            <input type="password" name="password" id="password" placeholder="Password">
        </div>
        <div class="campo enviar">
            <input type="hidden" id="tipo" value="login">
            <input type="submit" class="boton" value="Iniciar Sesión">
        </div>

        <div class="campo link">
            <a href="crear_cuenta.php">Crear Cuenta ></a>
        </div>
    </form>
</div>

<?php 
    include 'includes/template/footer.php';
?>
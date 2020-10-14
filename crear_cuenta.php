<?php 
    include 'includes/functions/functions.php';
    include 'includes/functions/connection.php';
    include 'includes/template/header.php';
?>

<div class="contenedor-formulario">
    <h1>UpTask</h1>
    <form id="formulario" class=" caja-login" method="post">
        <h2>Crear Cuenta</h2>
        <div class="campo">
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" placeholder="Usuario">
        </div>
        <div class="campo">
            <label for="password">Password: </label>
            <input type="password" name="password" id="password" placeholder="Password">
        </div>
        <div class="campo enviar">
            <input type="hidden" id="tipo" value="crear">
            <input type="submit" class="boton" value="Crear cuenta">
        </div>
        <div class="campo">
            <a href="login.php">Iniciar Sesión ></a>
        </div>
    </form>
</div>

<?php 
    include 'includes/template/footer.php';
?>
<?php 
    include 'includes/functions/sessions.php';
    include 'includes/functions/functions.php';
    include 'includes/template/header.php';
    include 'includes/template/barra.php';

    //Obtener id_proyecto
    if (isset($_GET['id_proyecto'])) {
        $id_proyecto = $_GET['id_proyecto'];
    }
    // echo "<pre>";
    // var_dump($_SESSION);
    // echo "</pre>";
    ?>
<div class="contenedor">
    <?php
        include 'includes/template/sidebar.php';
    ?>    <main class="contenido-principal">
        <?php
        if (isset($id_proyecto)){
            $nombre_proyecto = getProjectName($id_proyecto);
        }
            // echo "<pre>";
            // var_dump($nombre_proyecto);
            // echo "</pre>";
            if (isset($nombre_proyecto)):?> 
            <h1>Proyecto:
                <?php foreach ($nombre_proyecto as $nombre):?>
                    <span><?php echo $nombre['nombre'];?></span>
                <?php endforeach;?>
            </h1>

            <form action="#" class="agregar-tarea">
                <div class="campo">
                    <label for="tarea">Tarea:</label>
                    <input type="text" placeholder="Nombre Tarea" class="nombre-tarea"> 
                </div>
                <div class="campo enviar">
                    <input type="hidden" id="id_proyecto" value="<?php echo $id_proyecto?>">
                    <input type="submit" class="boton nueva-tarea" value="Agregar">
                </div>
            </form>

                <?php else://Si no hay proyectos
                    echo "<p>Selecciona un Proyecto de la izquierda</p>";
                endif;?>
        
 

        <h2>Listado de tareas:</h2>

        <div class="listado-pendientes">
            <ul>
            <?php
                $tareas = getTasks($id_proyecto);
                // echo "<pre>";
                // var_dump($tareas);
                // echo "</pre>";
                if ($tareas->num_rows > 0) {
                    foreach ($tareas as $tarea):?>
                        <li id="tarea:<?php echo $tarea['idTarea'] ?>" class="tarea">
                        <p><?php echo $tarea['nombre'] ?></p>
                            <div class="acciones">
                                <i class="far fa-check-circle
                                <?php //Operador ternario.
                                echo ($tarea['estado'] === '1' ? 'completo':'');
                                ?>
                                "></i>
                                <i class="fas fa-trash"></i>
                            </div>
                        </li>
                <?php endforeach;
                } else {
                    echo "<p class='lista-vacia'>No hay tareas agregadas.</p>";
                }
            ?>
            </ul>
        </div>
        <div class="avance">
            <h2>Avance del Proyecto:</h2>
            <div id="barra-avance" class="barra-avance">
                <div id="porcentaje" class="porcentaje"></div>
            </div>
        </div>
    </main>
</div><!--.contenedor-->

<?php 
    include 'includes/template/footer.php';
?>
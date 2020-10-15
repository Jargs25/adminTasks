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
    ?>    
    <div class="boton menu">
        <div class="icono">
            <i class="fas fa-bars"></i>
            <i class="fas fa-times"></i>
        </div>
    </div>
    <main class="contenido-principal">
        <?php
        if (isset($id_proyecto) && !empty($id_proyecto)){
            $nombre_proyecto = getProjectName($id_proyecto);
            // echo "<pre>";
            // var_dump($nombre_proyecto);
            // echo "</pre>";
            if (isset($nombre_proyecto)):?> 
                <h1>Proyecto:
                    <?php foreach ($nombre_proyecto as $nombre):?>
                        <span><?php echo $nombre['nombre'];?></span>
                    <?php endforeach;?>
                </h1>
                <div class="avance">
                    <h2>Avance:</h2>
                    <div class="barra-avance">
                        <div id="fondo" class="fondo"></div>
                        <div id="porcentaje" class="porcentaje">0%</div>
                    </div>
                </div>
    <?php   else://Si no hay proyectos
                echo "<div class='listado-pendientes'>
                        <h2 class='t-center'>Selecciona un Proyecto de la izquierda</h2>
                        </div>
                ";
            endif;?>
            
            <h2>Tareas:</h2>
            <form action="#" class="agregar-tarea">
                <div class="campo">
                    <label for="tarea">Tarea:</label>
                    <input type="text" placeholder="Nombre Tarea" class="nombre-tarea"> 
                    <input type="hidden" id="id_proyecto" value="<?php echo $id_proyecto?>">
                    <input type="submit" class="boton nueva-tarea" value="Agregar">
                </div>
            </form>
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
            <h2>Acciones:</h2>
            <div class="listado-pendientes">
                <ul>
                    <li>
                    <form action="#" class="acciones-proyecto">
                        <div class="campo">
                            <label>Nombre: </label>
                            <input type="text" placeholder="Nuevo nombre" 
                                <?php foreach ($nombre_proyecto as $nombre):?>
                                    value="<?php echo $nombre['nombre'];?>"
                                <?php endforeach;?>>
                                <input type="hidden" id="idProyecto" value="<?php echo $id_proyecto;?>">
                            <div class="acciones">
                                <i class="fas fa-edit"></i>
                                <i class="fas fa-trash"></i>
                            </div>
                        </div>
                    </form>
                    </li>
                </ul>
            </div>
        <?php
        } else {
            echo "<div class='listado-pendientes'>
                        <h2 class='t-center'>Selecciona un Proyecto de la izquierda</h2>
                    </div>
                ";
        }
        ?>
    </main>
</div><!--.contenedor-->

<?php 
    include 'includes/template/footer.php';
?>
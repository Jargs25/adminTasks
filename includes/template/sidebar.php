<aside class="contenedor-proyectos">
    <!-- <h3 class="titulo">Administración de Proyectos</h3> -->
        <div class="panel crear-proyecto">
            <a href="#" class="boton" id="<?php echo $_SESSION['id']?>"><span id="btnText">Nuevo Proyecto</span><i class="fas fa-plus"></i> </a>
        </div>
    
        <div class="panel lista-proyectos">
            <h2>Proyectos</h2>
            <ul id="proyectos">
            <!-- <li>
                <div class="new-proyect">
                    <input type="text" id="nuevo-proyecto">
                    <div class="boton">
                        <i class="far fa-check-square"></i>
                    </div>
                </div>
            </li> -->
                <?php
                $proyectos = getProjects($_SESSION['id']);

                if ($proyectos) {
                    foreach ($proyectos as $proyecto) { ?>
                        <li>
                            <a href="index.php?id_proyecto=<?php echo $proyecto['idProyecto'];?>" id="proyecto:<?php echo $proyecto['idProyecto'];?>">
                                <?php echo $proyecto['nombre'];?>
                            </a>
                        </li>
                        
                <?php   }
                }
                ?>
                
            </ul>
        </div>
    </aside>

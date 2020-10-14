<aside class="contenedor-proyectos">
        <div class="panel crear-proyecto">
            <a href="#" class="boton">Nuevo Proyecto <i class="fas fa-plus"></i> </a>
        </div>
    
        <div class="panel lista-proyectos">
            <h2>Proyectos</h2>
            <ul id="proyectos">
                <?php
                $proyectos = getProjects();

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

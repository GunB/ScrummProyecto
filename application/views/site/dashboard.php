<div class="container-fluid">
    <div class="row-fluid page-header">
        <div class="span9">
            <div class="">
                <h1>Listado de Proyectos <small>¡Aplica SCRUM ahora!</small><div style="float:right;"></div>
                </h1>
            </div>
        </div>
        <div class="span3">
            <a href="<?php echo site_url("proyectos/nuevo_proyecto"); ?>" class="btn btn-primary btn-success btn-large">Crear Proyecto</a>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="span9">
            <ul class="thumbnails">
                <?php
                foreach ($datos_proyectos->result() as $row) {
                    ?>

                    <li class="span3">
                        <div class="thumbnail">
                            <img style="display: none;" src="http://placehold.it/320x200" alt="ALT NAME">
                            <div class="caption">
                                <center><h3><?php echo $row->nombre; ?></h3>
                                <p><?php echo $row->ent_interesada; ?></p></center>
                                <p align="center"><a href="<?php echo site_url("proyectos/abrir_proyecto") . '/' . $row->id; ?>" class="btn btn-primary btn-info">Ver Proyecto</a></p>
                            </div>
                        </div>
                    </li>
                    <?php
                }
                ?>
                <li class="span3">
                    <div class="thumbnail">
                        <img style="display: none;" src="http://placehold.it/320x200" alt="ALT NAME">
                        <div class="caption">
                            <center><h3>Nuevo Proyecto</h3>
                            <p>¡Comienza un proyecto ahora!</p></center>
                            <p align="center"><a href="<?php echo site_url("proyectos/nuevo_proyecto"); ?>" class="btn btn-primary btn-success">CREAR</a></p>
                        </div>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>
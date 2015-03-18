<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <?php $temp=0; echo $menu_principal; ?>
        </div>
            <div class="span9">
                <table class="table">
                    <tr>
                        <td><h1><?php echo ucfirst($datos_proyecto['nombre']); ?></h1></td>
                    </tr>
                    <tr>
                        <td>Fase Inicial del Proyecto</td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            if ($boolequipo) {
                                ?>
                                <a class="btn btn-block btn-success" href="<?php echo site_url("equipo"); ?>">Modificar grupo de trabajo</a>
                                <?php
                            } else {
                                $temp++;
                                ?>
                                <a class="btn btn-block btn-warning" href="<?php echo site_url("equipo/crear_integrante"); ?>">Crear grupo de trabajo</a>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            if ($boolhistorias) {
                                ?>
                                <a class="btn btn-block btn-success" href="<?php echo site_url("historias"); ?>">Administrar pila del producto</a>
                                <?php
                            } else {
                                $temp++;
                                ?>
                                <a class="btn btn-block btn-warning" href="<?php echo site_url("historias/nueva_historia"); ?>">Crear pila de producto</a>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Fase Preliminar SCRUMs</td>
                    </tr>
                    <tr>

                        <td>
                            <?php
                            if ($boolprecision and $boolhistorias) {
                                ?>
                                <a class="btn btn-block btn-success" href="<?php echo site_url("historias/historias_para_precisar"); ?>">Precisar items de la pila de producto</a>
                                <?php
                            } else {
                                $temp++;
                                ?>
                                <a class="btn btn-block btn-warning" href="<?php echo site_url("historias/historias_para_precisar"); ?>">Precisar items de la pila de producto</a>
                                <?php
                            }
                            ?></td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            if ($boolduracion) {
                                ?>
                                <a class="btn btn-block btn-success"  href ="<?php echo site_url('proyectos/duracion_iteracion'); ?>">Editar duración del proyecto</a>
                                <?php
                            } else {
                                $temp++;
                                ?>
                                <a class="btn btn-block btn-warning"  href ="<?php echo site_url('proyectos/duracion_iteracion'); ?>">Seleccionar duración del proyecto</a>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                </table>
                <br><br>
                <center><a class="btn btn-large btn-danger" type="button" <?php if($temp==0){$link= site_url('proyectos/iniciar_scrum'); echo 'href="'.$link.'"'; }else{echo "disabled";}?>>SCRUM!</a></center>
            </div>       
        </div><!--/row-->
</div><!--/.fluid-container-->
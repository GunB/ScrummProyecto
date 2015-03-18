<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <?php echo $menu_principal; ?>
        </div>
        <div class="span9">
            <table class="table">
                <tr>
                    <?php
                    if ($daily_scrums_restantes < 1) {
                        if (isset($fin_proyecto)) {
                            ?>
                            <td><h1><?php echo ucfirst($datos_proyecto['nombre']); ?></h1></td><td><center><a class="btn btn-large btn-warning" href="<?php echo site_url('proyectos/iniciar_scrum'); ?>">FINALIZA EL PROYECTO</a></center></td>
                        <?php
                    } else {
                        ?>
                        <td><h1><?php echo ucfirst($datos_proyecto['nombre']); ?></h1></td><td><center><a class="btn btn-large btn-primary" href="<?php echo site_url('proyectos/iniciar_scrum'); ?>">SIGUIENTE ITERACIÓN!</a></center></td>
                        <?php
                    }
                } else {
                    ?>
                    <td><h1><?php echo ucfirst($datos_proyecto['nombre']); ?></h1></td><td><center><a class="btn btn-large btn-danger" href="<?php echo site_url('daily_scrum/panel_control'); ?>">DAILY SCRUM!</a></center></td>
                        <?php
                    }
                    ?>
                </tr>
                <tr>
                    <td><h3>ITERACIÓN <?php echo $iteracion->numero . " / " . $datos_proyecto['cantidad_iteraciones']; ?></h3></td>
                    <td><h3>Faltan <?php echo $daily_scrums_restantes; ?> daily scrums</h3></td>
                </tr>
                <tr>
                    <td>Meta</td>
                    <td><?php echo ucfirst($iteracion->meta); ?></td>
                </tr>
                <tr>
                    <td>Fecha DEMO de iteración</td>
                    <td><?php echo ucfirst($iteracion->fecha_entregable); ?></td>
                </tr>
                <tr>
                    <td>Lugar y Hora Daily SCRUM</td>
                    <td><?php echo ucfirst($iteracion->lugar_daily_scrum) . " / " . ucfirst($iteracion->hora_daily_scrum); ?></td>
                </tr>
                <tr>
                    <td><h3>Equipo de trabajo</h3></td>
                </tr>
                <?php
                for ($i = 0; $i < sizeof($equipo); $i++) {
                    echo "<tr>
                                  <td>" . ucfirst($equipo[$i]->nombre) . " " . ucfirst($equipo[$i]->apellidos) . "</td>   
                                  </tr>";
                }
                ?>
                <tr>
                    <td><h3>Items a desarrollar</h3></td>
                </tr>
                <?php
                for ($i = 0; $i < sizeof($historias); $i++) {
                    echo "<tr>
                                  <td>" . ucfirst($historias[$i]->nombre) . "</td>
                                  <td>" . ucfirst($historias[$i]->estado) . " (" . $historias[$i]->porcentaje . "%)</td>    
                                  </tr>";
                }
                ?>
            </table>
        </div>
    </div>
</div><!--/.fluid-container-->
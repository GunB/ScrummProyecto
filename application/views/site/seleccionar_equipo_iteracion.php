<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <?php echo $menu_principal; ?>
        </div>
        <div class="span9">
            <h3>Selecciona tu equipo de trabajo para la iteración <?php echo $ultima_iteracion; ?></h3>
            <?php
            if (isset($datos_equipo)) {
                ?>
                Creados durante esta iteración:
                <div class="well">
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Edad</th>
                                <th>Correo</th>
                                <th>Telefono</th>
                                <th style="width: 46px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;

                            foreach ($datos_equipo as $key => $value) {
                                ?>
                                <tr>
                                    <td><input type="checkbox" checked disabled></td>
                                    <td><?php echo $value->nombre ?></td>
                                    <td><?php echo $value->apellidos ?></td>
                                    <td><?php echo $value->edad ?></td>
                                    <td><?php echo $value->correo ?></td>
                                    <td><?php echo $value->telefono ?></td>
                                    <td>
                                        <a href = "<?php echo site_url("equipo/edicion_integrante") . "/" . $value->id ?>"><i class = "icon-pencil"></i></a>
                                        <a href = "#myModal" data="<?php echo $value->id ?>" role = "button" data-toggle = "modal"><i class = "icon-remove"></i></a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>      
    <?php
}
?>

            <form method="post" action="<?php echo site_url('equipo/confirmar_equipo'); ?>">
                Provenientes de iteraciones anteriores:
                <div class="well">
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Edad</th>
                                <th>Correo</th>
                                <th>Telefono</th>
                                <th style="width: 46px;"></th>
                            </tr>
                        </thead>
                        <tbody>
<?php
if (isset($equipo_trabajo)) {
    foreach ($equipo_trabajo as $key => $value) {
        ?>
                                    <tr>
                                        <td><input type="checkbox" name="check[]" value="<?php echo $value->id ?>"></td>
                                        <td><?php echo $value->nombre ?></td>
                                        <td><?php echo $value->apellidos ?></td>
                                        <td><?php echo $value->edad ?></td>
                                        <td><?php echo $value->correo ?></td>
                                        <td><?php echo $value->telefono ?></td>
                                        <td>
                                            <a href = "<?php echo site_url("equipo/edicion_integrante") . "/" . $value->id ?>"><i class = "icon-pencil"></i></a>
                                            <a href = "#myModal" data="<?php echo $value->id ?>" role = "button" data-toggle = "modal"><i class = "icon-remove"></i></a>
                                        </td>
                                    </tr>
        <?php
    }
}
?>

                        </tbody>
                    </table>
                </div>
                <a class="btn btn-primary" href="<?php echo site_url("equipo/crear_integrante"); ?>">Nuevo Usuario</a><p class="muted">Una persona creada en este punto quedará inscrita automáticamente como parte del equipo de esta iteración</p><br>
                <button type="submit" class="btn btn-primary">Confirmar equipo</button>
            </form>


            <div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Delete Confirmation</h3>
                </div>
                <div class="modal-body">
                    <p class="error-text">Are you sure you want to delete the user?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                    <button class="btn btn-danger" data-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
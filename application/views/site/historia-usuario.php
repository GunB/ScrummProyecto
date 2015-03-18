<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <?php echo $menu_principal; ?>
        </div>
        <div class="span9">
            <div class="btn-toolbar">
                <?php
                if (!$boolprecisar) {
                    if ($boolcero) {
                        ?>
                        <a href="<?php echo site_url('historias/nueva_historia'); ?>" class="btn btn-primary">Crear PBI</a>
                        <?php
                    } else {
                        ?>
                        <a href="<?php echo site_url('historias/precision_historia'); ?>" class="btn btn-primary">Crear PBI</a>
                        <?php
                    }
                }
                ?>
            </div>
            <h3>Listado del Producto</h3>
            Items que aun no han sido asignados a una iteración<br><br>
            <div class="well">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Prioridad</th>
                            <th>Titulo</th>
                            <th>Puntos de historia</th>
                            <th><?php //echo "Encargado"  ?></th>
                            <th>Descripcion</th>
                            <th>Entregable</th>
                            <th style="width: 46px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($historias)) {
                            foreach ($historias as $key => $value) {
                                ?>
                                <tr>
                                    <td><?php echo $value->prioridad ?></td>
                                    <td><?php echo $value->nombre ?></td>
                                    <td><?php echo $value->puntos_de_historia ?></td>
                                    <td><?php /*
                          if (isset($value->encargado))
                          echo $value->encargado;
                          else
                          echo "Aun no tiene encargado"; */
                                ?></td>
                                    <td><?php echo $value->descripcion ?></td>
                                    <td><?php
                                        if (isset($value->entregable))
                                            echo $value->entregable;
                                        else
                                            echo "Aun no tiene entregable";
                                        ?></td>
                                    <td>
                                        <a href="
                                        <?php
                                        if (!$boolprecisar) {
                                            if ($boolcero) {
                                                echo site_url("historias/edicion_historia" . "/" . $value->id);
                                            } else {
                                                echo site_url("historias/division_historia" . "/" . $value->id);
                                            }
                                        } else {
                                            echo site_url("historias/precision_historia" . "/" . $value->id);
                                        }
                                        ?>
                                           ">
                                            <i class="icon-cut"></i>
                                        </a>
                                        <a href="#myModal" role="button" data-id-historia="<?php echo $value->id ?>" data-toggle="modal"><i class="icon-remove"></i></a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Delete Confirmation</h3>
                </div>
                <div class="modal-body">
                    <p class="error-text">¿Seguro que desea eliminar esta hisoria de usuario?</p>
                </div>
                <form action="<?php echo site_url('historias/eliminar_historia') ?>" method="post" class="modal-footer">
                    <input type="hidden" value="" name="id">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                    <button class="btn btn-danger" data-dismiss="modal">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('a[data-id-historia]').on('click', null, function() {
        alert($(this).attr('data-id-historia'));
    });
</script>
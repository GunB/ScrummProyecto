<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <?php echo $menu_principal;?>
        </div>
        <div class="span9">
            <h3>Selecciona los items de la pila de producto a desarrollar esta iteración</h3>
            <form method="post" action="<?php echo site_url('historias/confirmar_historias_iteracion');?>">
            <div class="well">
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Prioridad</th>
                            <th>Titulo</th>
                            <th>Puntos de historia</th>
                            <th>Descripcion</th>
                            <th>Entregable</th>
                            <th style="width: 46px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=0;
                        if (isset($datos_historias)) {
                            foreach ($datos_historias as $key => $value) {
                                ?>
                                <tr>
                                <td><input type="checkbox" name="check[]" value="<?php echo $value->id ?>"></td>
                                <td><?php echo $value->prioridad ?></td>
                                <td><?php echo $value->nombre ?></td>
                                <td><?php echo $value->puntos_de_historia ?></td>
                                <td><?php echo $value->descripcion ?></td>
                                <td><?php echo $value->entregable ?></td>
                                <td>
                                <a href = "<?php echo site_url("equipo/edicion_integrante")."/".$value->id ?>"><i class = "icon-pencil"></i></a>
                                <a href = "#myModal" data="<?php echo $value->id ?>" role = "button" data-toggle = "modal"><i class = "icon-remove"></i></a>
                                </td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }                         
                        
                        ?>
                              
                        </tbody>
                </table>
            </div>
                <button type="submit" class="btn btn-primary">Confirmar items</button>
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
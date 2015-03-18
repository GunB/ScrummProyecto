<?php
$ultima_iteracion = $this->m_iteracion->obtener_ultima_iteracion($this->m_proyectos->obtener_id_proyecto_activo());
$ultimo_daily_scrum = $this->m_dailyscrum->obtener_ultimo_daily_scrum($iteracion->id, 1);

if(empty($ultimo_daily_scrum)){
    $ultimo_daily_scrum = new stdClass();
    $ultimo_daily_scrum->id = 0;
}
//var_dump($historias);
//var_dump($this->m_tareas->get_tareas_historia($historias[0]->id));
?>
<div class="container-fluid">
    <div class="row-fluid">
        <h1>Iteración <?php echo $iteracion->numero ?> <small>Daily Scrum <?php echo $daily_scrum->dia ?></small></h1>
    </div>
</div>

<div class="container-fluid">
    <div class="row-fluid">
        <table class="table">
            <tbody>
                <tr>
                    <td style="width: 10px;"></td>
                    <td><h1>Pendiente</h1></td>
                    <td><h1>En progreso</h1></td>
                    <td><h1>Finalizadas</h1></td>
                </tr>
                <?php
                foreach ($historias as $key => $value) {
                    //$tareas = ($this->m_tareas->get_tareas_historia($value->id));
                    //var_dump($tareas);
                    ?>
                    <tr>
                        <td>
                            <a href="#" class="icon-zoom-in btn btn-info" data-trigger="hover" data-placement="right" data-extra="popover" title="Administrar item de la pila del producto" data-content="Explora a fondo esta item de la pila del producto, podría ser refrescante." ></a>
                            <a href="#myModal2" data-toggle="modal" data-historia-id="<?php echo $value->id ?>" href="#" class="icon-plus-sign btn btn-info" data-trigger="hover" data-placement="right" data-extra="popover" title="Agregar tarea a la item de la pila del producto" data-content="¡Agrega mas tareas a esta item de la pila del producto!, Seguro que el trabajo nunca sobra" ></a>
                        </td>
                        <td>
                            <span class='title hidden'><?php echo $value->nombre ?></span>
                            <?php
                            foreach ($value->tareas as $key2 => $value2) {
                                if ($value2->estado_tarea_id == 1) {
                                    ?>
                                    <div class='thumbnails' >
                                        <div class="thumbnail tarea<?php echo $value2->tipo_tarea_id ?>">
                                            <?php
                                            if ($value2->tipo_tarea_id == 2) {
                                                echo "<b>Entregable:</b> ";
                                            }
                                            ?>
                                            <span><?php echo $value2->nombre; ?></span>
                                            <?php if ($ultima_iteracion->id == $iteracion->id and $ultimo_daily_scrum->id == $daily_scrum->id) { ?>
                                                <div>
                                                    <a href="#myModal" data-aumentar="true" data-id="<?php echo $value2->id; ?>" class="icon-upload-alt btn btn-success" data-trigger="hover" data-placement="right" data-extra="popover" data-toggle="modal" title="Aumentar estado de tarea" data-content="Cambia el estado de esta tarea, tu equipo de trabajo está dandolo todo para avanzar rápidamente en el proyecto, se necesita evidenciar." ></a>
                                                    <?php if ($value2->tipo_tarea_id != 2) { ?><a href="#myModal3" data-aumentar="false" data-id="<?php echo $value2->id; ?>" class="icon-trash btn btn-warning" data-trigger="hover" data-placement="right" data-extra="popover" data-toggle="modal" title="Eliminar tarea" data-content="Eliminar una tarea es una acción irreparable..." ></a> <?php } ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <span class='title hidden'><?php echo $value->nombre ?></span>
                            <?php
                            foreach ($value->tareas as $key2 => $value2) {
                                if ($value2->estado_tarea_id == 2) {
                                    ?>
                                    <div class='thumbnails' >
                                        <div class="thumbnail tarea<?php echo $value2->tipo_tarea_id ?>">
                                            <?php
                                            if ($value2->tipo_tarea_id == 2) {
                                                echo "<b>Entregable:</b> ";
                                            }
                                            ?>
                                            <span>
                                                <?php
                                                echo $value2->nombre;
                                                ?>
                                            </span>
                                            <?php if ($ultima_iteracion->id == $iteracion->id and $ultimo_daily_scrum->id == $daily_scrum->id) { ?>
                                                <div>

                                                    <a href="#myModal" data-aumentar="false" data-id="<?php echo $value2->id; ?>" class="icon-download-alt btn" data-trigger="hover" data-placement="right" data-extra="popover" data-toggle="modal" title="Disminuir estado de tarea" data-content="Cambia el estado de esta tarea, seguramente te equivocaste y seleccionaste la tarea equivocada, regresa tu error." ></a>
                                                    <a href="#myModal" data-aumentar="true" data-id="<?php echo $value2->id; ?>" class="icon-upload-alt btn btn-success" data-trigger="hover" data-placement="right" data-extra="popover" data-toggle="modal" title="Aumentar estado de tarea" data-content="Cambia el estado de esta tarea, tu equipo de trabajo está dandolo todo para avanzar rápidamente en el proyecto, se necesita evidenciar." ></a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <span class='title hidden'><?php echo $value->nombre ?></span>
                            <?php
                            foreach ($value->tareas as $key2 => $value2) {
                                if ($value2->estado_tarea_id == 3) {
                                    ?>
                                    <div class='thumbnails' >
                                        <div class="thumbnail tarea<?php echo $value2->tipo_tarea_id ?>">
                                            <?php
                                            if ($value2->tipo_tarea_id == 2) {
                                                echo "<b>Entregable:</b> ";
                                            }
                                            ?>
                                            <span>
                                                <?php
                                                echo $value2->nombre;
                                                ?>
                                            </span>
                                            <?php if ($ultima_iteracion->id == $iteracion->id and $ultimo_daily_scrum->id == $daily_scrum->id) { ?>
                                                <div>
                                                    <a href="#myModal" data-aumentar="false" data-id="<?php echo $value2->id; ?>" class="icon-download-alt btn" data-trigger="hover" data-placement="right" data-extra="popover" data-toggle="modal" title="Disminuir estado de tarea" data-content="Cambia el estado de esta tarea, seguramente te equivocaste y seleccionaste la tarea equivocada, regresa tu error." ></a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>

                        <td colspan="4">
                            <div class="progress">
                                <?php if ($value->porcentaje == 0) { ?><span><?php echo $value->nombre ?></span><?php } ?>
                                <div class="bar" style="width: <?php echo $value->porcentaje . "%" ?>;"><span><?php echo $value->nombre ?></span></div>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <?php if ($ultima_iteracion->id == $iteracion->id and $ultimo_daily_scrum->id == $daily_scrum->id) { ?>
            <form action="<?php echo site_url('daily_scrum/confirmar_dailyscrum'); ?>" method="post">
                <button class="btn btn-success btn-large" name="confirmar" value="true">Confirmar daily scrum</button>
            </form>
        <?php } else { ?>
            <a class="btn btn-info btn-large" href="<?php echo site_url('iteraciones/listado_iteraciones'); ?>">Regresar a la lista de daily scrums</a>
        <?php } ?>
    </div>
</div>

<?php if ($ultima_iteracion->id == $iteracion->id and $ultimo_daily_scrum->id == $daily_scrum->id) { ?>

    <!-- Modal -->
    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Confirmar el cambio de estado</h3>
        </div>
        <div class="modal-body">
            <p>¿Esta seguro que desea cambiar el estado?. </p>
            <div class="well">(<b>Tarea:</b> <i><span class="" id="nombre_tarea"></span></i>)</div>
            <small>Tenga en cuenta que esta acción no puede regresarse.</small>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Regresar</button>
            <button class="btn btn-primary" onclick="cambiar_estado();">Realizar cambio</button>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal3" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Confirmar el cambio de estado</h3>
        </div>
        <form class="modal-body">
            <input type="hidden" name="id">
            <p>¿Esta seguro que desea eliminar la tarea?. </p>
            <div class="well">(<b>Tarea:</b> <i><span class="" id="tarea_nombre"></span></i>)</div>
            <small>Tenga en cuenta que esta acción no puede regresarse.</small>
        </form>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Regresar</button>
            <button class="btn btn-primary" onclick="eliminar_tarea();">Realizar cambio</button>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Agregar Tarea</h3>
        </div>
        <form class="modal-body" action="<?php echo site_url('tarea/nueva_tarea') ?>" method="post">
            <p>Crea una nueva tarea a: <span id="historia_usuario_nombre"></span></p>
            <input type="hidden" name="id">
            <label>Nombre</label>
            <input type="text" name="nombre">
            <label>Detalles</label>
            <textarea name="descripcion"></textarea>
            <p><small>Tenga en cuenta que esta acción no puede regresarse.</small></p>
            <script>
                $(document).ready(function() {
                    $('#myModal2 form').validate({
                        rules: {
                            nombre: {
                                minlength: 5,
                                required: true
                            },
                            detalles: {
                                required: true
                            }
                        },
                        highlight: function(element) {
                            $(element).closest('.control-group').removeClass('success').addClass('error');
                        },
                        success: function(element) {
                            element
                                    .text('OK!').addClass('valid')
                                    .closest('.control-group').removeClass('error').addClass('success');
                        }
                    });
                }); // end document.ready
            </script>
        </form>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Regresar</button>
            <button class="btn btn-primary" onclick="agregar_tarea();">Agregar tarea</button>
        </div>
    </div>

    <script>
    <?php // <editor-fold defaultstate="collapsed" desc="cambiar_estados_tareas">
    ?>
                $aumenta = true;
                $id = '';
                $(document).ready(function() {
                    $('a[href="#myModal"]').on('click', null, function() {
                        $id = $(this).attr('data-id');
                        $("#nombre_tarea").html($(this).parent().siblings('span').html());
                        $aumenta = $(this).attr('data-aumentar');
                    });
                    $('[data-extra="popover"]').popover();
                });

                function cambiar_estado() {

                    $url = '';
                    if ($aumenta == 'true') {
                        $url = "<?php echo site_url('tarea/subir_estado'); ?>";
                    } else {
                        $url = "<?php echo site_url('tarea/bajar_estado'); ?>";
                    }

                    $.ajax({
                        url: $url,
                        type: 'post',
                        data: {tarea: $id},
                        beforeSend: function(xhr) {
                            $("#myModal .modal-body").html("<center><div class='thumbnail span2'><img src='<?php echo base_url() . "img-static/ajax-loader.gif"; ?>'></div></center>")
                            //xhr.overrideMimeType("text/plain; charset=x-user-defined");
                        }
                    }).done(function(data) {
                        console.log(data);
                        document.location.reload(true);
                    }).error(function(data) {
                        alert(data.statusText);
                        console.error(data.responseText);
                        setTimeout("document.location.reload(true)", 1);
                    });
                }

    <?php // </editor-fold>                ?>


                $(document).ready(function() {
                    $('a[href="#myModal2"]').on('click', null, function() {
                        $('#myModal2 form input[name="id"]').val($(this).attr('data-historia-id'));
                        $("#historia_usuario_nombre").html($(this).parent().siblings('td').find('.title').html());
                    });
                });

                function agregar_tarea() {

                    $url = '<?php echo site_url('tarea/nueva_tarea') ?>';
                    if ($("#myModal2 form").valid()) {

                        //$("#myModal2 form").submit();
                        $.ajax({
                            url: $url,
                            type: 'post',
                            data: $("#myModal2 form").serialize(),
                            beforeSend: function(xhr) {
                                $("#myModal2 .modal-body").html("<center><div class='thumbnail span2'><img src='<?php echo base_url() . "img-static/ajax-loader.gif"; ?>'></div></center>")
                                //xhr.overrideMimeType("text/plain; charset=x-user-defined");
                            }
                        }).done(function(data) {
                            if (console && console.log) {
                                console.log(data);
                            }
                            document.location.reload(true);
                        }).error(function(data) {
                            alert(data.statusText);
                            console.error(data.responseText);
                            setTimeout("document.location.reload(true)", 1);
                        });
                    } else {

                    }

                }

                $(document).ready(function() {
                    $('a[href="#myModal3"]').on('click', null, function() {
                        $('#myModal3 form input[name="id"]').val($(this).attr('data-id'));
                        $("#tarea_nombre").html($(this).parent().siblings('span').html());
                    });
                });

                function eliminar_tarea() {

                    $url = '<?php echo site_url('tarea/eliminar_tarea') ?>';

                    $.ajax({
                        url: $url,
                        type: 'post',
                        data: $("#myModal3 form").serialize(),
                        beforeSend: function(xhr) {
                            $("#myModal3 .modal-body").html("<center><div class='thumbnail span2'><img src='<?php echo base_url() . "img-static/ajax-loader.gif"; ?>'></div></center>")
                            //xhr.overrideMimeType("text/plain; charset=x-user-defined");
                        }
                    }).done(function(data) {
                        if (console && console.log) {
                            console.log(data);
                        }
                        document.location.reload(true);
                    }).error(function(data) {
                        alert(data.statusText);
                        console.error(data.responseText);
                        setTimeout("document.location.reload(true)", 1);
                    });


                }
    </script>

<?php } ?>


<?php // <editor-fold defaultstate="collapsed" desc="estilo">
?>
<style>
    .tareas{

        padding: 19px;
        margin-bottom: 20px;
        background-color: #f5f5f5;
        border: 1px solid #e3e3e3;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        position:relative;
        z-index: -3;
    }
    div .thumbnails{
        margin-top:5px;
        position:relative;
        z-index: 15;
    }

    .title{
        position:relative;
        font-size:47px;
        font-weight:bold;
        line-height:47px;
        color: #eee;
        z-index: -1;
        text-align: right;
        float: right;
    }
    .thumbnail{
        margin-bottom: 5px;
    }
    .tarea1{
        background: rgba(255,255,255,0.5);
    }
    .tarea2{
        background: rgba(255,255,0,0.4);
    }
</style>
<?php // </editor-fold>   ?>


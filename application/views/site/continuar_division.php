
<div class="container-fluid">
    <div class="row">
        <div class="span3">
            <?php echo $menu_principal; ?>
        </div>

        <div class="span9">
            <h2>DIVIDIR ELEMENTO "<?php echo ucfirst($datos_historia[0]->nombre); ?>"</h2>
            <form class="well" action="<?php echo site_url("historias/dividir_historia"); ?>" method="post">
                <input name="cantidad" type="hidden" value="<?php echo $cantidad; ?>"><input name="historia" value="<?php echo $datos_historia[0]->id; ?>" type="hidden">
                <?php
                for ($i = 0; $i < $cantidad; $i++) {
                    ?>
                    <h3>Historia hija <?php echo $i + 1; ?></h3>
                    <div class="row">
                        <div class="span3">
                            <label>Nombre</label>
                            <input name="nombre<?php echo $i; ?>" type="text">
                            <label>Prioridad</label>
                            <input name="prioridad<?php echo $i; ?>" type="text">
                            <label>Puntos de historia</label>
                            <input name="puntos_historia<?php echo $i; ?>" class="span2" type="text">
                            <label>Entregable</label>
                            <input name="entregable<?php echo $i; ?>" type="text">
                        </div>
                        <div class="span5">
                            <label>Descripcion</label>
                            <textarea name="descripcion<?php echo $i; ?>" id="message" class="input-xlarge span5" rows="14"></textarea>
                            <br>
                        </div>
                    </div>
                    
                <?php } ?>
                    
                    <script>
                        $(document).ready(function() {

                            // Validate
                            // http://bassistance.de/jquery-plugins/jquery-plugin-validation/
                            // http://docs.jquery.com/Plugins/Validation/
                            // http://docs.jquery.com/Plugins/Validation/validate#toptions

                            $('form').validate({
                                rules: {
                                  <?php  for ($i = 0; $i < $cantidad; $i++) { ?>
                                    nombre<?php echo $i; ?>: {
                                        minlength: 5,
                                        required: true
                                    },
                                    prioridad<?php echo $i; ?>: {
                                        number: true,
                                                minStrict: 1,
                                        required: true
                                    },
                                    puntos_historia<?php echo $i; ?>: {
                                        number: true,
                                        minStrict: 1,
                                        required: true
                                    },
                                    entregable<?php echo $i; ?>: {
                                        minlength: 20,
                                        required: true
                                    },
                                    descripcion<?php echo $i; ?>: {
                                        minlength: 20,
                                        required: true
                                    },
                                  <?php } ?>

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

                        });


                    </script>
                <br>
                <center><button type="submit" class="btn-large btn btn-primary">Confirmar</button></center>   
            </form>
        </div>
    </div>
</div>


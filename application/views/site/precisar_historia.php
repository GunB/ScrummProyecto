
<div class="container-fluid">
    <div class="row">
        <div class="span3">
            <?php echo $menu_principal; ?>
        </div>

        <div class="span9">
            <h2><?php if($boolcero){echo 'PRECISAR ELEMENTO DEL LISTADO';}else{echo 'CREAR NUEVO ITEM';} ?></h2>
             
                  <?php 
                  if($boolcero)
                  {
                      ?> <form class="well" action="<?php echo site_url("historias/precisar_historia") . "/" . $datos_historia[0]->id; ?>" method="post"> <?php
                  }
                  else 
                  {
                      ?> <form class="well" action="<?php echo site_url("historias/crear_historia_extra"); ?>" method="post"> <?php
                  }?>
                <div class="row">
                    <div class="span3">
                        <label>Nombre</label>
                        <input name='nombre' <?php if($boolcero){echo "readonly=''";}?> type="text" value="<?php if($boolcero){echo $datos_historia[0]->nombre;} ?>">
                        <label>Prioridad</label>
                        <input name='prioridad'<?php if($boolcero){echo "readonly=''";}?> type="text" value="<?php if($boolcero){echo $datos_historia[0]->prioridad;} ?>">
                        <label>Puntos de historia</label>
                        <input name="puntos_historia" class="span2" type="text" value='<?php if($boolcero){echo $datos_historia[0]->puntos_de_historia;} ?>'>
                        <label>Entregable</label>
                        <input name="entregable" type="text" value='<?php if($boolcero){echo $datos_historia[0]->entregable . "'";} ?>'>
                    </div>
                    <div class="span5">
                        <label>Descripcion</label>
                        <textarea name='descripcion' <?php if($boolcero){echo "readonly=''";}?> id="message" class="input-xlarge span5" rows="14"><?php if($boolcero){ echo $datos_historia[0]->descripcion; } ?></textarea>
                        
                    </div>

                    <button type="submit" class="btn btn-primary pull-right">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        // Validate
        // http://bassistance.de/jquery-plugins/jquery-plugin-validation/
        // http://docs.jquery.com/Plugins/Validation/
        // http://docs.jquery.com/Plugins/Validation/validate#toptions

        $('form').validate({
            rules: {
                nombre: {
                    minlength: 5,
                    required: true
                },
                apellidos: {
                    minlength: 5,
                    required: true
                },
                correo: {
                    email: true,
                    required: true,
                },
                edad: {
                    number: true, minStrict: 1,
                    required: true
                },
                telefono: {
                    number: true, minStrict: 1,
                    required: true
                },
                prioridad:{
                    number: true, minStrict: 1,
                    required: true
                },
                descripcion:{
                    minlength: 20,
                    required: true
                },
                duracion:{
                    number: true, minStrict: 1,
                    required: true
                },
                entregable:{
                    minlength: 20,
                    required: true
                },
                encargado:{
                    required: true
                },
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

<div class="container-fluid">
    <div class="row">
        <div class="span3">
            <?php echo $menu_principal; ?>
        </div>

        <div class="span9">
            <h2>DIVIDIR ELEMENTO "<?php echo ucfirst($datos_historia[0]->nombre); ?>"</h2>
                <div class="row">
                    <div class="span3">
                        <label>Nombre</label>
                        <input readonly="" type="text" value="<?php echo $datos_historia[0]->nombre; ?>">
                        <label>Prioridad</label>
                        <input readonly="" type="text" value="<?php echo $datos_historia[0]->prioridad; ?>">
                        <label>Puntos de historia</label>
                        <input readonly="" name="duracion" class="span2" type="text" value='<?php echo $datos_historia[0]->puntos_de_historia; ?>'> días
                        <label>Entregable</label>
                        <input readonly="" name="entregable" type="text" value='<?php echo $datos_historia[0]->entregable . "'"; ?>'>
                    </div>
                    <div class="span5">
                        <label>Descripcion</label>
                        <textarea readonly="" id="message" class="input-xlarge span5" rows="14"><?php echo $datos_historia[0]->descripcion; ?></textarea>                        
                    </div>
                    </div>
            <br>
            <form class="well" action="<?php echo site_url("historias/continuar_division") ?>" method="post">
            Deseo dividir esta historia en <input name="historia" type="hidden" value="<?php echo $datos_historia[0]->id; ?>"><input id="cantidad" style="width:25px;" name="cantidad" size="10"> partes <button type="submit" class="btn btn-primary">Confirmar</button>   
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
                    required: true
                },
                historia: {
                    number: true,
                    minStrict: 1,
                    required: true
                },
                telefono: {
                    number: true,
                    required: true
                },
                prioridad:{
                    number: true,
                    required: true
                },
                descripcion:{
                    minlength: 20,
                    required: true
                },
                duracion:{
                    number: true,
                    minStrict: 1,
                    required: true
                },
                entregable:{
                    minlength: 20,
                    required: true
                },
                encargado:{
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

    });
    
            $( "#cantidad" ).keypress(function() {
                                
});

</script>
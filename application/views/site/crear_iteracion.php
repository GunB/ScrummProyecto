<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <?php echo $menu_principal; ?>
        </div>
        <div class="span9">
            <form action="<?php echo site_url("iteraciones/iteracion_creada"); ?>" method="post">
                <table class="table">
                    <tr>
                        <td><h2><?php echo ucfirst($datos_proyecto['nombre']); ?> </h2></td>
                        <td><h3>ITERACIÓN <?php echo $ultima_iteracion; ?></h3></td>
                    </tr>
                    <tr>
                        <td><h3>Meta:</h3><input name="meta" type="text"></td>
                    </tr>
                    <tr>
                        <td><h3>Fecha DEMO de iteración:</h3><input name="fecha_entregable" type="text"></td>
                    </tr>
                    <tr>
                        <td><h3>Lugar Daily Scrum:</h3><input name="lugar_dscrum" type="text"></td>
                    </tr>
                    <tr>
                        <td><h3>Hora Daily Scrum:</h3><input name="hora_dscrum" type="text"></td>
                    </tr>
                </table>   
                <button class="btn btn-large btn-info" type="submit">CONFIRMAR</button>
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
                entidad: {
                    minlength: 4,
                    required: true
                },
                duracion: {
                    number: true,
                    minStrict: 1,
                    required: true
                },
                descripcion: {
                    minlength: 20,
                    required: true
                },
                meta:{
                    minlength: 20,
                    required: true
                },
                entregable:{
                    minlength: 20,
                    required: true
                },
                fecha_entregable:{
                    minlength: 5,
                    required: true
                },
                lugar_dscrum:{
                    minlength: 10,
                    required: true
                },
                hora_dscrum:{
                    minlength: 3,
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
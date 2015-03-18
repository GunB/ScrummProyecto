
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <?php echo $menu_principal; ?>
        </div>
        <div class="span9">
            <form action="<?php echo site_url("proyectos/editar_duracion_iteracion"); ?>" method="post">
                <table class="table">
                    <tr>
                        <td><h1>NOMBRE PROYECTO</h1></td>
                    </tr>
                    <tr>
                        <td><h3>Duración del proyecto:</h3>
                            <input <?php
                            if (isset($datos_proyecto['duracion'])) {
                                echo "value='" . $datos_proyecto['duracion'] . "' ";
                            }
                            ?>
                            name="duracion" type="text" id="duracion">
                            <select id="multiplicador" name="multiplicador">
                                <option value="25">meses</option><option value="5">semanas</option><option selected value="1">días</option>
                            </select>
                            <br><p class="muted">El sistema toma meses de 25 y semanas de 5 días hábiles respectivamente</p></td>

                    </tr>
                    <tr>
                        <td><h3>Duración de iteracion:</h3>
                        <input <?php
                        if (isset($datos_proyecto['duracion_iteracion'])) {
                            echo "value='" . $datos_proyecto['duracion_iteracion'] . "' ";
                        }
                        ?>
                        name="duracion_iteracion" type="text"> días</td>
                    </tr>
                </table>
                <p class="muted"> Se sugiere que una iteración no supere los 20 días. </p>   
                <button class="btn btn-large btn-info" type="submit">CONFIRMAR</button>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        <?php
                            if (isset($datos_proyecto['duracion'])) {
                            ?>
                                  $( "#duracion" ).val(<?php echo $datos_proyecto['duracion'];?>);  
                                  var dias = <?php echo $datos_proyecto['duracion'];?>
                            <?php
                            }
        ?>

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
                duracion_iteracion:{
                    number: true, minStrict: 1,
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
        
                $( "#multiplicador" ).change(function() {
                    
                    $( "#duracion" ).val(dias/$( "#multiplicador" ).val());
});

$( "#duracion" ).keyup(function() {
  dias = $( "#duracion" ).val()*$( "#multiplicador" ).val();
});

    }); // end document.ready
</script>
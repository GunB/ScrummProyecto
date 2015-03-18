
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <div class="well sidebar-nav">
                <ul class="nav nav-list">
                    <li class="nav-header"><a href="<?php echo site_url("proyectos/listado_proyectos"); ?>">Mis Proyectos</a></li>
                </ul>
            </div>
        </div>
        <div class="span9">
            <form id="form" action="<?php echo site_url("proyectos/proyecto_creado"); ?>" method="post">
                <table class="table">
                    <tr>
                        <td><h1>NUEVO PROYECTO</h1></td>
                    </tr>
                    <tr>
                        <td><h3>Nombre:</h3><input name="nombre" type="text"></td>
                    </tr>
                    <tr>
                        <td><h3>Entidad Interesada:</h3><input name="entidad" type="text"></td>
                    </tr>
                    <tr>
                        <td><h3>Descripción:</h3><textarea name="descripcion"></textarea></td>
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

        $('#form').validate({
            rules: {
                nombre: {
                    minlength: 5,
                    required: true
                },
                entidad: {
                    minlength: 4,
                    required: true,
                },
                duracion: {
                    number: true,
                    required: true
                },
                descripcion: {
                    minlength: 20,
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
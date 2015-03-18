<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="" id="loginModal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3>Ya tienes una cuenta?</h3>
                </div>
                <div class="modal-body">
                    <div class="well">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#login" data-toggle="tab">Iniciar Sesión</a></li>
                            <li><a href="#create" data-toggle="tab">Nueva Cuenta</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane active in" id="login">
                                <form class="form-horizontal" action='<?php echo site_url("sesion/iniciar_sesion"); ?>' method="POST">
                                    <fieldset>
                                        <div id="legend">
                                            <legend class="">Iniciar Sesión</legend>
                                        </div>    
                                        <div class="control-group">
                                            <!-- Correo -->
                                            <label class="control-label"  for="correo">Correo</label>
                                            <div class="controls">
                                                <input type="text" name="correo" placeholder="" class="input-xlarge">
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <!-- Password-->
                                            <label class="control-label" for="password">Clave</label>
                                            <div class="controls">
                                                <input type="password" name="clave" placeholder="" class="input-xlarge">
                                            </div>
                                        </div>


                                        <div class="control-group">
                                            <!-- Button -->
                                            <div class="controls">
                                                <button class="btn btn-success">Iniciar Sesión</button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="create">
                                <form id="tab" method="post" action="<?php echo site_url("sesion/crear_cuenta"); ?>">

                                    <label>Nombre de Usuario</label>
                                    <input name="nombre" type="text" value="" class="input-xlarge">
                                    <label>Clave</label>
                                    <input name="clave" type="text" value="" class="input-xlarge">
                                    <label>Correo Electrónico</label>
                                    <input name="correo" type="text" value="" class="input-xlarge">

                                    <div>
                                        <button class="btn btn-primary">Create Account</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        // Validate
        // http://bassistance.de/jquery-plugins/jquery-plugin-validation/
        // http://docs.jquery.com/Plugins/Validation/
        // http://docs.jquery.com/Plugins/Validation/validate#toptions

        $('form').each(function() {
            $(this).validate({
                rules: {
                    nombre: {
                        minlength: 5,
                        required: true
                    },
                    clave: {
                        minlength: 5,
                        required: true
                    },
                    correo: {
                        email: true,
                        required: true,
                    },
                    edad: {
                        number: true,
                        minStrict: 1,
                        required: true
                    },
                    telefono: {
                        number: true,
                        required: true
                    },
                    prioridad: {
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
        });

    }); // end document.ready
</script>    
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <?php echo $menu_principal; ?>
        </div>
        <div class="span9">
            <form <?php if(isset($datos_integrante))
                      { $accion = site_url('equipo/editar_integrante')."/".$datos_integrante[0]->id;
                        echo "action='".$accion."'";
                      }
                      else
                      {
                         $accion = site_url('equipo/insertar_integrante');
                        echo "action='".$accion."'"; 
                      }?> method="post">
                <table class="table">
                    <tr>
                        <td><h1><?php echo $this->m_proyectos->obtener_nombre_proyecto_activo(); ?></h1></td>
                    </tr>
                    <tr>
                        <td><h3>Nuevo integrante del grupo de trabajo</h3></td>
                    </tr>
                    <tr>
                        <td><label>Nombres:</label><input name="nombre" type="text" <?php if(isset($datos_integrante)){echo "value='".$datos_integrante[0]->nombre."'";}?> ></td>
                    </tr>
                    <tr>
                        <td><label>Apellidos:</label><input name="apellidos" type="text" <?php if(isset($datos_integrante)){echo "value='".$datos_integrante[0]->apellidos."'";}?> ></td>
                    </tr>
                    <tr>
                        <td><label>Edad:</label><input name="edad" type="text" <?php if(isset($datos_integrante)){echo "value='".$datos_integrante[0]->edad."'";}?>></td>
                    </tr>
                    <tr>
                        <td><label>Correo electrónico:</label><input name="correo" type="text" <?php if(isset($datos_integrante)){echo "value='".$datos_integrante[0]->correo."'";}?>></td>
                    </tr>
                    <tr>
                        <td><label>Teléfono:</label><input name="telefono" type="text" <?php if(isset($datos_integrante)){echo "value='".$datos_integrante[0]->telefono."'";}?>></td>
                    </tr>
                </table>  
                <input class="btn btn-large btn-info" type="submit" value="Agregar">
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
                    minlength: 3,
                    required: true
                },
                apellidos: {
                    minlength: 3,
                    required: true
                },
                correo: {
                    email: true,
                    required: true,
                },
                edad: {
                    number: true,
                    required: true
                },
                telefono: {
                    number: true,
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
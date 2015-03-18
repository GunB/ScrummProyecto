
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
       <?php echo $menu_principal;?>
        </div>
        <div class="span9">
            <form 
                <?php if(isset($datos_historia[0]))
                      { $accion = site_url('historias/editar_historia')."/".$datos_historia[0]->id;
                        echo "action='".$accion."'";
                      }
                      else
                      {
                         $accion = site_url('historias/crear_historia');
                        echo "action='".$accion."'"; 
                      }?> 
                method="post">
                <table class="table">
                    <tr>
                        <td><h3><?php if(isset($datos_historia)){echo "EDITAR ITEM DEL LISTADO DE PRODUCTO";} else {echo "NUEVO ITEM DEL LISTADO DE PRODUCTO";}?></h3></td>
                        <td><br><button class="btn btn-large btn-info" type="submit">CONFIRMAR</button></td>
                    </tr>
                    <tr>
                        <td><label>Nombre:</label><input name="nombre" type="text" <?php if(isset($datos_historia)){echo "value='".$datos_historia[0]->nombre."'";}?>></td>
                    </tr>
                    <tr>
                        <td><label>Prioridad:</label><input name="prioridad" type="text" <?php if(isset($datos_historia)){echo "value='".$datos_historia[0]->prioridad."'";}?>>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Descripción:</label><textarea name="descripcion"><?php if(isset($datos_historia)){echo $datos_historia[0]->descripcion;}?></textarea></td>
                    </tr>  
                </table>   
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
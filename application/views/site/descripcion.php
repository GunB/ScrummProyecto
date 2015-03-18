<?php
$id_proyecto = $this->m_proyectos->obtener_id_proyecto_activo();
$proyecto = $this->m_proyectos->datos_proyecto($id_proyecto);
?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
<?php echo $menu_principal; ?>
        </div>
        <div class="span9">
            <table class="table">
                <tr>
                    <td colspan="2"><h1><?php echo $proyecto['nombre']; ?></h1></td>
                </tr>
                <tr>
                    <td>Duración</td>
                    <td><?php echo $proyecto['duracion']; ?> días</td>
                </tr>
                <tr>
                    <td>Duración de iteración</td>
                    <td><?php echo $proyecto['duracion_iteracion']; ?> días</td>
                </tr>
                <tr>
                    <td>Entidad Interesada</td>
                    <td><?php echo $proyecto['entidad']; ?></td>
                </tr>
                <tr>
                    <td>Descripción</td>
                    <td><?php echo $proyecto['descripcion']; ?></td>
                </tr>
            </table>
        </div>
    </div>
</div><!--/row-->
<?php
function dameURL() {
    return current_url();
} 
?>
<div class="well sidebar-nav">
    <ul class="nav nav-list">
        <li class="nav-header"><a href="<?php echo site_url("proyectos/listado_proyectos"); ?>">Mis Proyectos</a></li>
        
        <li class="nav-header">
            <?php 
            echo $this->m_proyectos->obtener_nombre_proyecto_activo(); 
            ?>
        </li>
        <li class=" <?php if((dameURL() == site_url("proyectos/admin_proyecto"))){ echo "active";}else{ echo "blink";} ?>">
            <a href="<?php echo site_url("proyectos/admin_proyecto"); ?>">Panel de SCRUM Master</a>
        </li>
        <li class="<?php if(dameURL() == site_url("proyectos/informacion_proyecto")){ echo "active";} ?>">
            <a href="<?php echo site_url("proyectos/informacion_proyecto"); ?>">Información del proyecto</a>
        </li>
        <li class="<?php if(dameURL() == site_url("equipo")){ echo "active";} ?>">
            <a href="<?php echo site_url("equipo"); ?>">Equipo de Trabajo</a>
        </li>
        <li class="<?php if(dameURL() == site_url("historias")){ echo "active";} ?>">
            <a href="<?php echo site_url("historias"); ?>">Listado del Producto</a>
        </li>
        <li class="<?php if(dameURL() == site_url("iteraciones/listado_iteraciones")){ echo "active";} ?>">
            <a href="<?php echo site_url("iteraciones/listado_iteraciones"); ?>">Iteraciones</a>
        </li>
        <li><hr></li>
        <li class="nav-header"><a href="#">Configuración</a></li>
        <li class="nav-header"><a href="<?php echo site_url("sesion/cerrar_sesion") ?>">Cerrar Sesión</a></li>
    </ul>
</div><!--/.well -->
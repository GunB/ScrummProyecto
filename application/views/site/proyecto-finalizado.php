<?php
if ($_SERVER['HTTP_REFERER'] !== site_url('proyectos/informacion_proyecto')) {
    redirect('proyectos/informacion_proyecto');
} else {
    
}
?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <?php echo $menu_principal; ?>
        </div>
        <div class="span9">
            <div class="page-header">
                <h1>¡Tu proyecto '<?php echo $datos_proyecto['nombre'] ?>' ha finalizado!</h1>
            </div>
            <div>
                <p>
                    Muchas gracias por usar este producto, esperamos que el proyecto esté finalizado con exito y claro, la documentación qui consignada sea de ayuda.
                    Siempre podrás verificar lo que sucedió durante los pasados Daily SCRUMs en el menú de <a href="<?php echo site_url('iteraciones/listado_iteraciones'); ?>">Iteraciones</a>
                </p>
            </div>
            <div>
                <p>
                    Para información mas general sobre el desarollo del proyecto, te invitamos a observar la información del proyecto
                </p>
            </div>
            <div>
                <a href="<?php echo site_url('proyectos/informacion_proyecto'); ?>" class="btn btn-large">
                    Observar la información relevante del proyecto
                </a>
            </div>
            <br><br>
            <div>
                <p>
                    Por último, es posible que tengas la necesidad de crear una iteración mas... puede que el proyecto no se terminase como se esperaba, por tanto, la opción para crear una iteración extra siempre estará al alcance de un click.
                </p>
            </div>
            <div>
                <a href="<?php echo site_url('iteraciones/crear_iteracion_extra') ?>" class="btn btn-large btn-danger">
                    Crea una iteración extra
                </a>
            </div>
        </div>
    </div>
</div>
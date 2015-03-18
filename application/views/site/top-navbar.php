<div class="navbar navbar-inverse">
    <div class="navbar-inner">
        <div class="container-fluid">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="brand" href="<?php echo base_url() ?>">SCRUM MANAGER</a>
            <div class="nav-collapse collapse">
                <?php if (isset($this->m_sesion->obtener_sesion()->nombre)) { ?>
                    <p class="navbar-text pull-right">
                        Bienvenido 
                        <a href="#" class="navbar-link"><?php echo $this->m_sesion->obtener_sesion()->nombre; ?></a>
                        <?php echo $this->m_sesion->obtener_id_sesion(); ?>
                    </p>
                        <?php
                }
                ?>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>
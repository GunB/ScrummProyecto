<?php
// <editor-fold defaultstate="collapsed" desc="header">
$this->load->view('base/head');
$this->load->view('base/body');
$this->m_sesion->comprobar_sesion();
$this->m_proyectos->comprobar_proyecto_activo();
// </editor-fold> 
?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="" id="loginModal">
                <div class="modal-body">
                    <div class="well">
                        <center>
                            <h3>
                                <?php
                                if (isset($mensaje)) {
                                    echo $mensaje;
                                } else {
                                    echo "Oops!, ha ocurrido un error... regresa y confirma que todo está bien";
                                }
                                ?>
                            </h3>
                            <?php $url = site_url("inicio"); ?>
                            <a class="btn btn-success" href='<?php echo $_SERVER['HTTP_REFERER'] ?>'>Continuar</a>
                            <SCRIPT LANGUAGE="JavaScript">
                                setTimeout("history.back(1)", 2000);
                            </SCRIPT>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
// <editor-fold defaultstate="collapsed" desc="footer">
$this->load->view('base/foot'); // </editor-fold> ?>
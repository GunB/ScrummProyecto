<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="" id="loginModal">
                <div class="modal-body">
                    <div class="well">
                        <center>
                            <h3>
                                <?php
                                echo $cuenta_creada;
                                ?>
                            </h3>
                            <?php $url = site_url("inicio"); ?>
                            <a class="btn btn-success" href='<?php echo $url; ?>'>Continuar</a>
                            <SCRIPT LANGUAGE="JavaScript">
                                setTimeout("location.href='<?php echo $url ?>'", 2000);
                            </SCRIPT>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
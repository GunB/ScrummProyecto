<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3">
            <?php echo $menu_principal; ?>
        </div>
        <div class="span9">

            <?php
            //var_dump($iteraciones);
            foreach ($iteraciones as $key => $value) {
                if ($value->numero != "0") {
                    ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>
                                    <h1><?php echo "ITERACIÓN " . $value->numero; ?></h1>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($value->daily_scrums as $key2 => $value2) { ?>
                                <tr>
                                    <td>
                                        <form action="<?php echo site_url('daily_scrum/panel_control'); ?>" method="post">
                                            <input type="hidden" name="iteracion" value="<?php echo $value->id ?>">
                                            <input type="hidden" name="dia" value="<?php echo $value2->id ?>">
                                            <button value="" class="btn-link">Daily scrum <?php echo ($value2->dia) ?></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php
                }
            }
            ?>



        </div>
    </div>
</div>
<style>
    form{
        margin: 0 0;
    }
</style>
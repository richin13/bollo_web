<?php if (!defined("BOLLO_WEB")) die("Direct initialization of this file is not allowed."); ?>
<div class="col-xs-12 col-sm-7 col-sm-offset-2 col-md-7 col-md-offset-2 col-lg-6">
    <?php
    $token = $_GET['activate'];
    if (activate_user($token)) { ?>
        <div class="row text-center">
            <h4>Se activó correctamente!</h4>
            <a href="../" title="">
                <img src="../image/Happy_cat.jpg" class="img-responsive center-block"/></a>
        </div>
    <?php } else { ?>
        <div class="row text-center">
            <h4>¿Estás en el lugar correcto?</h4>
            <a href="../" title="Volver al inicio">
                <img src="../image/nothing_to_do.jpg" class="img-responsive center-block"/></a>
        </div>
    <?php } ?>
</div>
<?php
/**
 *
 * @file          content-success.php
 * @author        ricardo
 * @version       2.1.23
 * @copyright     (c) 2015 Ricardo Madriz
 * @licensing     GNU GPL 2.0
 * @link          http://www.TEST.net
 *
 * This software is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Date: 24/10/15
 * Time: 12:11 AM
 */
if (!defined("BOLLO_WEB")) die("Direct initialization of this file is not allowed."); ?>
<div class="col-xs-12 col-sm-7 col-sm-offset-2 col-md-7 col-md-offset-2 col-lg-6">
    <?php
    $success = $_GET['success'];
    if ($success == "signup") { ?>
        <div class="row text-center">
            <h4>Se completó el registro correctamente!</h4>

            <p>Por favor revisa tu dirección de correo <b><?php echo htmlspecialchars($_GET['email']) ?></b>
                para activar la cuenta.</p>
        </div>
    <?php } elseif ($success == "updated-pw") { ?>
        <div class="row text-center">
            <h4>Se actualizó la contraseña correctamente!</h4>

            <p>Ahora puede ingresar a su cuenta.</p>
        </div>
    <?php } elseif ($success == "sent-recovery-email") { ?>
        <div class="row text-center">
            <h4>Se han enviado las instrucciones!</h4>

            <p>Se han enviado las instrucciones para recuperar tu cuenta
                al correo electrónico
                <b><?php echo htmlspecialchars($_GET['email']); ?></b></p>
        </div>
    <?php } ?>
</div>
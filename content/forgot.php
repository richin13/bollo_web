<?php if (!defined("BOLLO_WEB")) die("Direct initialization of this file is not allowed."); ?>
<div class="col-xs-12 col-sm-7 col-sm-offset-2 col-md-7 col-md-offset-2 col-lg-6">
    <?php if (empty($_GET['forgot'])) { ?>
        <div class="row text-center">
            <h4>Recuperar contraseña!</h4>

            <p>Se enviará un correo con los pasos necesarios para recuperar tu cuenta</p>

            <form class="form-inline" id="recovery-request-form">
                <div id="forgot-email-group" class="form-group">
                    <label for="forgot-email">Correo electrónico</label>
                    <input type="email" id="forgot-email" class="form-control" placeholder="Email" name="email"
                           required>
                    <button type="submit" class="btn btn-primary">Recuperar</button>
                    <span id="forgot-block-password" class="help-block hidden has-error">
                            <i class="fa fa-warning"></i> Ese correo no está asociado a ningún usuario :(.
                        </span>
                </div>
            </form>
        </div>
    <?php } else { ?>
        <div class="row">
            <h4 class="text-center">Establece una nueva contraseña!</h4>

            <p class="text-center">Escoge una contraseña fuerte</p>

            <form id="forgot-form">
                <div class="col-xs-12">
                    <div id="password-group" class="form-group">
                        <label class="control-label" for="password">Contraseña</label>
                        <input type="password" id="password" class="form-control" name="password"
                               placeholder="Contraseña" required>
                        <span id="warning-block-password" class="help-block hidden has-error">
                            <i class="fa fa-warning"></i> La contraseña es muy corta.
                        </span>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div id="confirm-pw-group" class="form-group">
                        <label class="control-label" for="c-password">Confirmar Contraseña</label>
                        <input type="password" id="c-password" class="form-control" name="c-password"
                               placeholder="Confirme" required>
                            <span id="warning-block-pw-mismatch" class="help-block hidden has-error"><i
                                    class="fa fa-warning"></i> Las contraseñas no coinciden.</span>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div id="pw-recovery-error-msg" class="alert alert-danger hidden" role="alert"><i
                            class="fa fa-exclamation-triangle"></i>El formulario contiene errores
                    </div>
                </div>
                <input type="hidden" name="forgot" value="<?php echo htmlspecialchars($_GET['forgot']) ?>">

                <div class="col-xs-3 col-xs-offset-9">
                    <div class="form-group">
                        <button type="submit" id="pw-recovery-submit" class="btn btn-primary">Recuperar</button>
                    </div>
                </div>
            </form>
        </div>
    <?php } ?>
</div>
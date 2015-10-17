<?php
/**
 *
 * @file          signup.php
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
 * Date: 23/10/15
 * Time: 10:53 PM
 */
if (!defined("BOLLO_WEB")) die("Direct initialization of this file is not allowed."); ?>
<div class="col-xs-12 col-md-7 col-md-offset-2 col-lg-6">
    <div class="row">
        <h4>Registrarse</h4>
    </div>
    <form id="signup-form" method="post">
        <div class="row">
            <div class="col-xs-12 col-md-6 col-lg-6">
                <div id="firstname-group" class="form-group">
                    <label for="firstname">Nombre</label>
                    <input type="text" id="firstname" class="form-control" name="firstname"
                           placeholder="Nombre" required>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-6">
                <div id="lastname-group" class="form-group">
                    <label for="lastname">Apellido</label>
                    <input type="text" id="lastname" class="form-control" name="lastname"
                           placeholder="Apellido" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
                <div id="email-group" class="form-group">
                    <label class="control-label" for="email">Email</label>
                    <input type="email" id="email" class="form-control" name="email" placeholder="Email"
                           required>
                    <span id="warning-block-email" class="help-block hidden"><i class="fa fa-warning"></i> Ya existe una cuenta asociada a este correo electrónico.</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
                <div id="username-group" class="form-group">
                    <label class="control-label" for="username">Usuario</label>
                    <input type="text" id="username" class="form-control" name="username"
                           placeholder="Usuario" required>
                                <span id="warning-block-username" class="help-block hidden"><i
                                        class="fa fa-warning"></i> Ya existe ese usuario.</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-6 col-lg-6">
                <div id="password-group" class="form-group">
                    <label class="control-label" for="password">Contraseña</label>
                    <input type="password" id="password" class="form-control" name="password"
                           placeholder="Contraseña" required>
                    <span id="warning-block-password" class="help-block hidden has-error">
                        <i class="fa fa-warning"></i> La contraseña es demasiado corta.
                    </span>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-6">
                <div id="confirm-pw-group" class="form-group">
                    <label class="control-label" for="c-password">Confirmar Contraseña</label>
                    <input type="password" id="c-password" class="form-control" name="c-password"
                           placeholder="Confirme" required>
                    <span id="warning-block-pw-mismatch" class="help-block hidden has-error">
                        <i class="fa fa-warning"></i> Las contraseñas no coinciden.
                    </span>
                </div>
            </div>
        </div>
        <div class="row gcaptcha">
            <div class="col-xs-12 col-md-6 col-md-offset-2 col-lg-6 col-lg-offset-2">
                <div class="g-recaptcha" data-sitekey="6LdPusESAAAAAHTPn0Ls1ZUaULsvLy8YvyKHmsU0"></div>
            </div>
        </div>
        <div class="row text-center">
            <div id="signup-error-msg" class="alert alert-danger hidden" role="alert"><i
                    class="fa fa-exclamation-triangle"></i>El formulario contiene errores
            </div>
            <div id="signup-loading" class="hidden">
                <i class="fa fa-spinner fa-spin fa-3x"></i>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-offset-6 col-lg-6 col-lg-offset-6">
                <a href="#" data-toggle="modal" data-target="#loginModal" class="btn btn-default">Ya soy
                    miembro</a>
                <button type="submit" id="signup-submit" class="btn btn-primary">Enviar</button>
            </div>
        </div>
    </form>
</div>
<script src='https://www.google.com/recaptcha/api.js'></script>
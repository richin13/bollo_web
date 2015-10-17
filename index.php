<?php
/**
 *
 * @file          index.php
 * @author        ricardo
 * @version       2.1.23
 * @copyright     (c) 2015 Ricardo Madriz
 * @licensing     GNU GPL 2.0
 * @link          http://bollo-server.bitnamiapp.com/bollo_web/
 *
 * This software is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Date: 21/10/15
 * Time: 03:20 PM
 */
session_start();
$_SESSION['init'] = true;
define("BOLLO_WEB", true);
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="es_CR">
<head>
    <title><?php echo $bollo_web['title'] ?></title>
    <meta charset="utf-8">
    <meta name="description" content="Interfaz web del sistema de administración de panaderías Bollo">
    <meta name="author" content="Ricardo Madriz">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/general.css" type="text/css"/>
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="bower_components/flat-ui/dist/css/flat-ui.min.css"/>
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="bower_components/animate.css/animate.min.css">
    <link rel="stylesheet" href="bower_components/sweetalert/dist/sweetalert.css">

    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/flat-ui/dist/js/flat-ui.min.js"></script>
    <script language="JavaScript" src="bower_components/sweetalert/dist/sweetalert.min.js"></script>
    <script src="js/bollo.js"></script>
</head>
<body>
<nav id="bollo-top-bar" class="navbar navbar-inverse">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./">Bollo</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="http://bollostatus.tk" target="_blank" title="Estado de los servicios">
                        <i class="fa fa-check"></i> Estado</a>
                </li>
                <li>
                    <a href="?faqs"><i class="fa fa-question"></i> F.A.Q</a>
                </li>
                <li>
                    <a href="?about"><i class="fa fa-info"></i> Acerca</a>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle fake_link" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false" id="user-dropdown"><i class="fa fa-user"></i> Aplicación <span
                            class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php if (!$bollo_web['user_in']) { ?>
                            <li><a href="#" data-toggle="modal" data-target="#loginModal">Entrar</a></li>
                            <li><a href="?signup">Registrarse</a></li>
                        <?php } else { ?>
                            <li><a href="?profile"><?php echo htmlspecialchars($_SESSION['user_name']); ?></a></li>
                            <li><a href="?cp">Panel de control</a></li>
                            <li class="divider"></li>
                            <li><a href="?logout">Cerrar sesión</a></li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->

</nav>

<div class="container" id="content-wrapper">
    <?php
    if (!$bollo_web['include_err'] && $bollo_web['user_in']) {
        include_once 'content/cp-navbar.php';
    }
    include_once $bollo_web['include_once'];
    ?>

</div>
<div class="clearfooter"></div>
<footer class="footer">
    <div class="container">
        <div class="row">
            <p class="small text-center color-gray">
                Hecho en Costa Rica con <i class="color-red fa fa-heart"></i> y mucho
                <i class="color-brown fa fa-coffee"></i>
            </p>
        </div>
    </div>
</footer>
</body>
<?php if (!$bollo_web['user_in']) { ?>
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="loginModalLabel">Iniciar sesión</h4>
                </div>
                <form id="login-form" method="post">
                    <div class="modal-body" id="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email/Usuario</label>
                            <input type="text" class="form-control" name="user" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Contraseña</label>
                            <input type="password" class="form-control" name="password"
                                   placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label class="checkbox" for="keep-me">
                                <input type="checkbox" value="" id="keep-me" data-toggle="checkbox" name="remember"> No
                                cerrar sesión
                            </label>
                        </div>
                        <div class="text-center">
                            <div id="login-error-msg" class="alert alert-danger hidden" role="alert"><i
                                    class="fa fa-exclamation-triangle"></i>Datos erroneos
                            </div>
                            <div id="login-loading" class="hidden">
                                <i class="fa fa-spinner fa-spin fa-3x"></i>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button id="login-close" type="button" class="btn btn-default" data-dismiss="modal">Cerrar
                        </button>
                        <button id="login-submit" type="submit" class="btn btn-primary">
                            Entrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ./login-modal-->
<?php } ?>
</html>
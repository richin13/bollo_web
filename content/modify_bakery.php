<?php
/**
 *
 * @file          modify_bakery.php
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
 * Date: 04/11/15
 * Time: 02:49 PM
 */
if (!defined("BOLLO_WEB")) die("Direct initialization of this file is not allowed.");

$bakery = get_bakery($_GET['modify'])[0];
?>
<h1>Editar panadería
    <small><?php echo $bakery->getName(); ?></small>
</h1>
<div class="col-xs-12 col-md-7 col-md-offset-2 col-lg-6">
    <form id="edit-bakery-form" method="post">
        <input name="id" type="hidden" value=<?php echo $_GET['modify']; ?>>

        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" name="name"
                           value="<?php echo $bakery->getName(); ?>" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label class="control-label" for="state">Provincia</label>
                    <select class="form-control" name="state">
                        <?php foreach (provinces() as $id => $name) { ?>
                            <option value=<?php echo $id;
                            if ($bakery->getProvince() == $id) echo " selected"; ?>><?php echo $name ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label class="control-label" for="city">Ciudad</label>
                    <input type="text" class="form-control" name="city"
                           value="<?php echo $bakery->getCity(); ?>" required>
                </div>
            </div>
        </div>
        <div class="row text-center">
            <div id="edit-success-msg" class="alert alert-success hidden" role="alert"><i
                    class="fa fa-check"></i> Se guardaron los cambios
            </div>
            <div id="edit-error-msg" class="alert alert-danger hidden" role="alert"><i
                    class="fa fa-exclamation-triangle"></i> El formulario contiene errores
            </div>
            <div id="edit-loading" class="hidden">
                <i class="fa fa-spinner fa-spin fa-3x"></i>
            </div>
        </div>
        <div class="row">
            <div class="text-center">
                <button type="submit" id="create-submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar
                </button>
            </div>
        </div>
    </form>
</div>
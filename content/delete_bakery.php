<?php
/**
 *
 * @file          delete_bakery.php
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
 * Time: 08:41 PM
 */
if (!defined("BOLLO_WEB")) die("Direct initialization of this file is not allowed.");
?>
<h1>Borrando panadería</h1>
<hr>
<p>Espere mientras se completa el proceso...</p>
<div id="delete-success" class="alert alert-success hidden" role="alert">Se eliminó la panadería correctamente. En breve
    será redirigido
</div>
<div id="delete-error" class="alert alert-danger hidden" role="alert">Ocurrió un error al intentar borrar la panadería.
    Error:
</div>
<input id="deleting-bakery" name="id" type="hidden" value="<?php echo $_GET['delete']; ?>">
<script language="JavaScript">
    $("#delete-success").addClass("hidden");
    $("#delete-error").addClass("hidden");
    $.ajax({
        type: 'GET',
        url: 'api/v1/bakeries/deletle.php',
        data: {id: $('#deleting-bakery').val()},
        dataType: 'json',
        encode: true
    }).done(function (data) {
        console.log(data);
        if (!data.code) {
            $("#delete-success").removeClass("hidden");
            window.setTimeout(function () {
                window.location.href = '?welcome';
            }, 5000);
        } else {
            $("#delete-error").removeClass("hidden").append(data.code);
        }
    }).fail(function (e) {
        console.log(e);
        $("#delete-error").removeClass("hidden").append(403);
    });

</script>

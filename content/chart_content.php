<?php
/**
 *
 * @file          chart_content.php
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
 * Date: 09/11/15
 * Time: 09:23 PM
 */
if (!defined("BOLLO_WEB")) die("Direct initialization of this file is not allowed."); ?>
<script language="JavaScript" src="bower_components/Chart.js/Chart.min.js"></script>
<h1>Gráficos
    <small>Producción de pan 2015</small>
</h1>
<hr>
<div id="loading-charts" class="text-center hidden">
    <h2>Cargando gráficos <i class="fa fa-cog fa-spin"></i></h2>
</div>
<div class="row">
    <div style="width: 50%" class="text-center">
        <canvas id="canvas" height="450" width="800"></canvas>
    </div>
</div>
<script>
    var bakery_id;
    <?php if(!empty($_GET["charts"])) {?>
    bakery_id = <?php echo htmlspecialchars($_GET["charts"]) ?>;
    <?php } else {?>
    bakery_id = false;
    <?php } ?>
</script>

<script language="JavaScript" src="js/charts.js"></script>
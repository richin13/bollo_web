<?php
/**
 *
 * @file          bakery_content.php
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
 * Time: 12:49 PM
 */
if (!defined("BOLLO_WEB")) die("Direct initialization of this file is not allowed."); ?>
<h1>Panaderías</h1>
<div class="row">
    <span class="pull-right"><a href="#" id="refresh-bakery"><i class="fa fa-refresh"></i></a> </span>
</div>
<div id="content-bakeries">
</div>
<div id="loading-bakeries" class="text-center hidden">
    <h2>Cargando <i class="fa fa-cog fa-spin"></i></h2>
</div>
<div id="no-bakeries" class="alert alert-info hidden" role="alert">No hay ninguna panadería.</div>
<div id="failed" class="alert alert-danger hidden" role="alert">
    <i class="fa fa-warning"></i>
    No se encontró la panadería
</div>
<script language="JavaScript" src="js/bakeries.js"></script>
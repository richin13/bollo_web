<?php
/**
 *
 * @file          problems-entries.php
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
 * Date: 04/11/15
 * Time: 12:06 PM
 */
if (!defined("BOLLO_WEB")) die("Direct initialization of this file is not allowed."); ?>
<h1>Problemas</h1>
<hr>
<div class="row">
    <div class="col-md-6">
        <form class="form-inline" method="get" name="filter" id="filter">
            <label class="control-label" for="filter">Filtrar
                <select class="form-control" name="filter">
                    <option value="0" selected>Cargando...</option>
                </select>
            </label>
        </form>
    </div>
    <div class="col-md-6">
        <span class="pull-right"><a href="#" title="Refrescar" id="refresh"><i class="fa fa-refresh"></i></a></span>
    </div>
</div>
<hr>
<table id="table-problem" class="table table-striped">
    <thead>
    <tr>
        <th>Código</th>
        <th>Panadería</th>
        <th>Descripción</th>
        <th title="Cantidad de masa afectada">Masa</th>
        <th>Fecha</th>
        <th>Hora</th>
    </tr>
    </thead>
    <tbody>

    </tbody>
</table>
<div id="loading-problems" class="text-center hidden">
    <h2>Cargando <i class="fa fa-cog fa-spin"></i></h2>
</div>
<div id="no-entries" class="alert alert-info hidden" role="alert">Aún no se ha generado ningún problema.</div>
<div id="failed" class="alert alert-danger hidden" role="alert">
    <i class="fa fa-warning"></i>
    Ocurrió un error grave. ¿Desea
    <a href="#" class="alert-link" title="Reintentar">reintentar</a>?
</div>
<script language="JavaScript" src="js/logbook.js"></script>

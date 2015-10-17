<?php if (!defined("BOLLO_WEB")) die("Direct initialization of this file is not allowed."); ?>
<nav id="cp-navbar" class="navbar navbar-default sidebar" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-sidebar-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="?welcome">
                        <i class="fa fa-home"></i> Inicio
                    </a>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle fake_link" data-toggle="dropdown">
                        <i class="fa fa-dashboard"></i> Panaderías
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="?bakery" title="Ver todas la panaderías">Ver</a></li>
                        <li><a href="?create" title="Crear una nueva panadería">Crear</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a class="dropdown-toggle fake_link" data-toggle="dropdown">
                        <i class="fa fa-calendar-o"></i> Reportes
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="?events">Eventos</a></li>
                            <li><a href="?problems">Problemas</a></li>
                        </ul>
                </li>

                <li>
                    <a href="?charts">
                        <i class="fa fa-pie-chart"></i>Gráficos
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
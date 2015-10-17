<?php
/**
 *
 * @file          about.php
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
 * Date: 02/11/15
 * Time: 10:17 PM
 */
if (!defined("BOLLO_WEB")) die("Direct initialization of this file is not allowed."); ?>
<h1 class="text-right">Acerca de...</h1>
<div>Bollo es un sencillo pero poderoso y extensible sistema de administración de panaderías. Está compuesto
    por una aplicación central de monitoreo instalada en una (ó N) computadora (s) y una aplicación web
    accesible desde cualquier parte del mundo para consultar y configurar el funcionamiento de las panaderías
    que se administran mediante el sistema. Ambos sistemas coexisten gracias a una interfaz de programa de
    aplicación (API) que gestiona el acceso a los recursos de información utilizados por ambos sistemas.
    <a name="authors"></a>
    <h3>Autores</h3>
    <hr>
    <ul>
        <li>Daniel Aguilar</li>
        <li>Daniel Castillo</li>
        <li>Ricardo Madriz</li>
    </ul>
    <a name="components"></a>
    <h3>Componentes</h3>
    <hr>
    <ul>
        <li><b>Bollo&trade;</b>:</li> Bollo es la aplicación central del sistema.
        Es una aplicación de escritorio desde la cual se pueden configurar los detalles del funcionamiento
        de las panaderías de la franquicia.
        <li><b>Bollo&trade; Web</b>:</li> BolloWeb es la interfaz web de la aplicación
        desde la cual se puede acceder a toda la información de las panaderías desde cualquier parte del planeta.
        <li><b>Bollo&trade; API</b>:</li> Bollo API es una interfaz de programa de
        aplicación (API, por sus siglas en inglés), encargada de gestionar el acceso a la información de las
        panaderías administradas con Bollo&trade;.
    </ul>
    <a name="nerds"></a>
    <h3>Datos para nerds</h3>
    <hr>
    <ul>
        <li><b>Bollo&trade;</b>:
            <ul>
                <li>Escrita en C++ usando el framework Qt version 5.5.1</li>
                <li>16000 líneas de código agregadas al repositorio en <i class="fa fa-github-alt"></i> </li>
            </ul>
        </li>
        <li><b>Bollo&trade; Web</b>:
            <ul>
                <li>Diseñada con HTML5, CSS3 y Javascript usando el framework jQuery.</li>
                <li>5 componentes instalados y administrados con Bower</li>
                <li>170000 líneas de código</li>
            </ul>
        </li>
        <li><b>Bollo&trade; API</b>
            <ul>
                <li>Escrita en PHP 5.6</li>
                <li>Bases de datos con PostgreSQL versión 9.2</li>
                <li>1476 líneas de código PHP</li>
                <li>9 tablas SQL</li>
                <li>100 líneas de código SQL</li>
                <li>Contiene 3 secciones, la primera con 3 modulos, segunda con 1 y la última con 4.</li>
                <li>PHPMailer para el envío de correos electrónicos a través de SMTP</li>
            </ul>
        </li>
        <li><b>Bollo&trade; Bot (Telegram)</b>
            <ul>
                <li>Escrito en Node js 4.2</li>
                <li>Front end con Express & Jade</li>
                <li>Alojado en Heroku</li>
            </ul>
        </li>
        <li><b>Servidor Web</b>:
            <ul>
                <li>LAPP stack: Linux, Apache, PHP & PostgreSQL</li>
                <li>Máquina virtual alojada en AWS - Cloud computing services</li>
                <li>Launchpad por Bitnami</li>
            </ul>
        </li>
        <li><b>General</b>:
            <ul>
                <li>Entornos de desarrollo por JetBrains: <b>CLion</b> versión 1.1 y <b>PHPStorm</b> version 10</li>
                <li>Editor de texto: Atom</li>
                <li>Mucho de esto no habría sido posible
                    sin la ayuda de
                    <a href="https://education.github.com/pack"> Github Student Developer Pack</a></li>
            </ul>
        </li>
        <li><b>Curiosidades</b>:
            <ul>
                <li>Todos los componentes y librerías utilizados son de código abierto</li>
                <li>3 libras de café.</li>
                <li>Mucha agua.</li>
                <li>Durante el desarrollo sufrimos un ataque 'Analisis de vulnerabilidades'. El malware
                    utilizado entró a través de diferentes proxies en Rumania y su firma en las cabeceras de HTTP era
                    <a href="http://www.skepticism.us/2015/05/new-malware-user-agent-value-jorgee/">'Mozila/5.0 Jorgee
                        '</a></li>
                <li>Inicialmente se utilizó Google Cloud para alojar el servidor, sin embargo este sufría serios
                    problemas
                    a la hora de utilizar COOKIES.
                </li>
            </ul>
        </li>
    </ul>
</div>

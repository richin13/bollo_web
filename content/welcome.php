<?php if (!defined("BOLLO_WEB")) die("Direct initialization of this file is not allowed."); ?>
<h1 class="text-right">Hola mundo!</h1>
<small> Bienvenido</small>
<p>Este es un sistema sencillo de administración de panaderías que ofrece una interfaz web para revisar el
    estado
    y la principal información de las panaderías que se administran.
    <?php if ($bollo_web['user_in']) { ?>
        Utilice el menú superior para para navegar
        por las secciones administrativas de la aplicación.
    <?php } else { ?>
        Para comenzar, por favor regístrese en
    la página web con un nombre de usuario y una contraseña. Una vez registrado podrá empezar a consultar
    información a través de la página web.
    <?php } ?>
    <br><br><b>Gracias por su preferencia </b> <i class="color-red fa fa-heart"></i></p>
<br>
<address>
    <strong>Bollo Dev Team</strong>
</address>

<img src="image/icon.png" alt="Bollito"/>
<!DOCTYPE html>
<html>
<head>
<title>Activar</title>
</head>

<body>
<?php
  include("../core/config.php");
  include(DIR_BOLLO."/core/query.php");

  if (isset($_GET['activate_token'])) {
    $token = $_GET['activate_token'];
    activate_user($token);
?>
  <h1>Se activó correctamente!</h1>
  <img src="img/Happy_cat.jpg" />
<?php
  } else {
?>
  <img src="img/nothing_to_do.jpg" />
<?php
  }
?>
</body>

</html>

<?php
function email_forgotten_pw($email, $token) {
  $from = "Bollo - Password recovery";
  $subject = "Password recovery details";
  $body = "Hola, recientemente se ha solicitado un cambio de contrasenia\n
  Ingresa al siguiente enlace para restablecer la constrasenia\n
  <a href='http://DOMAIN.dom/bollo_web/public/forgot.php?token=$token'>
  Click aqui</a>";

  return mail($email, $subject, $body, $from);
}

function email_details($fname, $lname, $username, $email, $token, $phone = "") {
  $from = "Bollo - Welcome";
  $subject = "Welcome to Bollo";
  $body = "Gracias'$fname' '$lname' por registrarte en Bollo.\n
  Tu nombre de usuario: '$username'\n
  Tu telefono: '$phone'\n
  Ingresa al siguiente link para activar la cuenta\n
  <a href='http://DOMAIN.dom/bollo_web/public/activate.php?activate_token='$token''>ACTIVAR</a>";

  return mail($email, $subject, $body, $from);
}
?>

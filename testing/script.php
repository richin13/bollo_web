<?php
  ini_set('display_errors', 'On'); #Debug purposes!
  $bytes = openssl_random_pseudo_bytes(8);
  $token = bin2hex($bytes);
  var_dump($token);
  echo $token;
?>

<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 'On'); #Debug purposes!

  define('DIR_BOLLO', __DIR__);//FIXME: Warning!

  function get_token($length = 8) {
    return $token = bin2hex(openssl_random_pseudo_bytes($length));
  }


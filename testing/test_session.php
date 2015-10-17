<?php
require_once '../config.php';
require_once DIR_BOLLO . '/core/query.php';

if(activate_user("")) {
    echo "All good!";
} else {
    echo "All bad!";
}
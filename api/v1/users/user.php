<?php
/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 11/10/15
 * Time: 04:27 PM
 */
include('../../../config.php');

header('Content-type: application/json; charset=utf-8');
$response = array();

$params = !(isset($_GET['id']) ? $_GET['id'] : false) ?
    !(isset($_GET['username']) ? $_GET['username'] : false) ?
        !(isset($_GET['email']) ? $_GET['email'] : false) ?
            false :
            array('user_email', $_GET['email']) :
        array('user_username', $_GET['username']) :
    array('user_id', $_GET['id']);

if ($params) {
    $user = get_user($params[0], $params[1]);
    if ($user) {
        $response = array('code' => 0, 'message' => "Ok!", "user" => $user);
    } else {
        $response = array('code' => 1, 'message' => "No user found!", 'info' => $params[1]);
    }
} else {
    /* Is not a identification request - Handle it! */
    $response = array('code' => 15, 'message' => "Missing parameters!");
}

echo json_encode($response, JSON_PRETTY_PRINT);
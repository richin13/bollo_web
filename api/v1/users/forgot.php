<?php
include('../../../config.php');
require_once(DIR_BOLLO . '/core/query.php');
require_once(DIR_BOLLO . '/core/email.php');

header('Content-type: application/json');
$response = array();

if (isset($_GET['api_token'])) {
    $token = $_GET['api_token'];

    if (check_api_token($token)) {
        if (isset($_GET['user_email'])) {
            $email = $_GET['user_email'];
            $user_token = get_token();

            if (assign_token($user_token, $email)) {
                if (email_forgotten_pw($email, $user_token)) {
                    $response = array('code' => 0, 'status' => 'Ok!');
                } else {
                    $response = array('code' => 15, 'message' => "Could not send email!");
                }
            } else {
                $response = array('code' => 16, 'message' => "Invalid information!");
            }
        } else {
            $response = array('code' => 17, 'message' => "Missing user_email param!");
        }
    } else {
        $response = array('code' => -1, 'message' => "Invalid security token!");
    }
} else {
    $response = array('code' => -2, 'message' => "Missing security token!");
}

echo json_encode($response, JSON_PRETTY_PRINT);

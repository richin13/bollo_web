<?php
include('../../../config.php');
require_once(DIR_BOLLO . '/core/query.php');
require_once(DIR_BOLLO . '/core/email.php');

header('Content-type: application/json');
$response = array();

if (isset($_GET['api_token'])) {
    $token = $_GET['api_token'];

    if (check_api_token($token)) {
        $all_set = isset($_GET['fname']) && isset($_GET['lname']) &&
            isset($_GET['username']) && isset($_GET['pw']) &&
            isset($_GET['mail']);

        if ($all_set) {
            $f_name = $_GET['fname'];
            $l_name = $_GET['lname'];
            $username = $_GET['username'];
            $password = $_GET['pw'];
            $email = $_GET['mail'];

            $phone_num = isset($_GET['phone']) ? $_GET['phone'] : NULL;

            if (sign_up($f_name, $l_name, $username, $password, $email, $phone_num)) {
                $inactive_token = get_token(10);
                $success = create_inactive_user($username, $inactive_token);
                $success = $success && email_details($f_name, $l_name, $username, $email, $inactive_token, $phone_num);
                if ($success) {
                    $response = array("code" => 0, "message" => "Ok!");
                } else {
                    #delete_user($username);
                    $response = array("code" => 15, "message" => "Error. Try again later!");
                }
            } else {
                $response = array("code" => 16, "message" => "User already exists!");
            }
        } else {
            $response = array("code" => 17, "message" => "Missing parameters!");
        }
    } else {
        $response = array("code" => -1, "message" => "Invalid API token!");
    }
} else {
    $response = array("code" => -2, "message" => "Missing security token!");
}

echo json_encode($response, JSON_PRETTY_PRINT);

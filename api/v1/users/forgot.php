<?php
include('../../../config.php');

header('Content-type: application/json; charset=utf-8');
$response = array();

$email = isset($_GET['email']);
$forgot = isset($_GET['forgot']);
$id = user_id($_GET['email']);
if ($email && !$forgot) {
    $email = $_GET['email'];
    $user_token = get_token();
    if ($id > 0) {
        $data = join(":", array($id, $email, $user_token));
        $data = secure_data($data);
        assign_token($id, $data);
        if (email_forgotten_pw($email, $data)) {
            $response = array('code' => 0, 'status' => 'Ok!');
        } else {
            $response = array('code' => 1, 'message' => "Could not send email!");
        }
    } else {
        $response = array('code' => 2, 'message' => "Email doesn't exist!");
    }
} elseif ($forgot && !$email) {
    if (isset($_GET['password'])) {
        $password = hash('sha256', $_GET['password'], false);
        $data = $_GET['forgot'];
        if (reset_password($id, $password, $data)) {
            $response = array('code' => 0, 'status' => 'Ok!');
        } else {
            $response = array('code' => 5, 'status' => 'Invalid data');
        }
    } else {
        $response = array('code' => 15, 'message' => "Missing parameters");
    }
} else {
    $response = array('code' => 15, 'message' => "Missing parameters");
}

echo json_encode($response, JSON_PRETTY_PRINT);

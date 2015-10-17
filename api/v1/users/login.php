<?php
/**
 *
 * @file          login.php
 * @author        ricardo
 * @version       2.1.23
 * @copyright     (c) 2015 Ricardo Madriz
 * @licensing     GNU GPL 2.0
 * @link          http://www.TEST.net
 *
 * This software is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Date: 21/10/15
 * Time: 08:33 PM
 */
require_once '../../../config.php';

header('Content-type: application/json; charset=utf-8');
$response = array();

if (isset($_GET['user']) and isset($_GET['password'])) {
    $username = $_GET['user'];
    $password = hash('sha256', $_GET['password'], false);
    $user = login($username, $password);

    if ($user) {
        if (!is_iaccount($username)) {
            if(!isset($_GET['bolloapp'])) {//To avoid creating session when login from C++ application.
                session_start();
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['user_name'] = $user->getFirstName();
                $_SESSION['user_lname'] = $user->getLastName();
                $_SESSION['user'] = $user->getUsername();
                $_SESSION['user_email'] = $user->getEmail();

                if (isset($_GET['remember'])) {
                    $token = join(":", array($_SESSION['user_id'], $_SESSION['user_email'], get_token(32)));
                    $token = secure_data($token);
                    if (create_session($token, $_SERVER['REMOTE_ADDR'], $user->getId())) {
                        setcookie("session_persist", $token, time() + (86400 * 30), "/");
                    }
                }
            }
            $response = array("code" => 0, "message" => "Ok", "user_details" => $user);
        } else {
            $response = array("code" => 1, "message" => "Account has not been activated");
        }
    } else {
        $response = array("code" => 2, "message" => "Invalid credentials!");
    }
} else {
    $response = array("code" => 15, "message" => "Missing parameters");
}

echo json_encode($response, JSON_PRETTY_PRINT);
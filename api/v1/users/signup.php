<?php
include('../../../config.php');

header('Content-type: application/json; charset=utf-8');
$response = array();

$all_set = isset($_GET['firstname']) && isset($_GET['lastname']) &&
    isset($_GET['username']) && isset($_GET['password']) &&
    isset($_GET['email']) && isset($_GET['g-recaptcha-response']);
if ($all_set) {
    $firstname = $_GET['firstname'];
    $lastname = $_GET['lastname'];
    $username = $_GET['username'];
    $password = $_GET['password'];
    $email = $_GET['email'];
    $captcha = $_GET['g-recaptcha-response'];
    if (validate($firstname, $lastname, $username, $email, $password)) {
        if (valid_captcha($captcha)) {
            if (($new_user_id = sign_up($firstname, $lastname, $username, $password, $email))) {
                $user_token = join(":", array($new_user_id, $email, get_token()));
                $data = secure_data($user_token);
                $success = create_inactive_user($new_user_id, $username, $data);
                $success = $success && email_details($firstname, $username, $email, $data);
                if ($success) {
                    $response = array("code" => 0, "message" => "Ok!");
                } else {
                    delete_user($username);
                    $response = array("code" => 1, "message" => "Error. Try again later!");
                }
            } else {
                $response = array("code" => 2, "message" => "User already exists!");
            }
        } else {
            $response = array("code" => 3, "message" => "Spammer!");
        }
    } else {
        $response = array("code" => 4, "message" => "Invalid information.");
    }
} else {
    if (isset($_GET['g-recaptcha-response'])) {
        $response = array("code" => 15, "message" => "Missing parameters!");
    } else {
        $response = array("code" => 16, "message" => "Missing captcha!");
    }
}

echo json_encode($response, JSON_PRETTY_PRINT);

/**
 * @param $firstname string the firstname to check.
 * @param $lastname string the lastname to check.
 * @param $username string the username, must have 6 characters or more.
 * @param $email string The email.
 * @param $password string hash of the password, if not a hash, it'll be converted without failing validation.
 * @return bool true if all the provided information has an acceptable format.
 */
function validate($firstname, $lastname, $username, $email, &$password) {
    if (empty($firstname) || empty($lastname) || empty($username) || empty($email) || empty($password)) {
        return false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    } elseif (strlen($username) < 6) {
        return false;
    } else {
        $password = hash('sha256', $_GET['password'], false);
        return true;
    }
}

function valid_captcha($captcha) {
    $params = http_build_query(array(
        'secret' => '6LdPusESAAAAAJDCJ40tNhCtqDVqMvIYtQwIcSXu',
        'response' => $captcha,
        'remoteip' => $_SERVER['REMOTE_ADDR']
    ));
    $url = sprintf("%s?%s", "https://www.google.com/recaptcha/api/siteverify", $params);
    $response = file_get_contents($url);
    $json_response = json_decode($response);

    return $json_response->success;
}

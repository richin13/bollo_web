<?php
/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 14/10/15
 * Time: 06:48 PM
 */

include('../../../config.php');
require_once(DIR_BOLLO . '/core/query.php');
require_once(DIR_BOLLO . '/core/email.php');

header('Content-type: application/json');
$response = array();

if (isset($_GET['api_token'])) {
    $token = $_GET['api_token'];

    if (check_api_token($token)) {
        $all_set = isset($_GET['name']) && isset($_GET['state']) &&
            isset($_GET['city']);

        if ($all_set) {
            $bakery_name = $_GET['name'];
            $bakery_state = $_GET['state'];
            $bakery_city = $_GET['city'];
            if (add_bakery($bakery_name, $bakery_state, $bakery_city)) {
                $response = array("code" => 0, "message" => "Ok!");
            } else {
                $response = array("code" => 16, "message" => "Error inserting the bakery!");
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


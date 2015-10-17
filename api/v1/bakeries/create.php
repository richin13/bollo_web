<?php
/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 14/10/15
 * Time: 06:48 PM
 */

include('../../../config.php');

header('Content-type: application/json; charset=utf-8');
$response = array();

$all_set = isset($_GET['name']) && isset($_GET['state']) &&
    isset($_GET['city']);

if ($all_set) {
    $bakery_name = $_GET['name'];
    $bakery_state = $_GET['state'];
    $bakery_city = $_GET['city'];
    if (($id = add_bakery($bakery_name, $bakery_state, $bakery_city))) {
        $response = array("code" => 0, "message" => "Ok!", "bakery" => get_bakery((int)$id)[0]);
    } else {
        $response = array("code" => 1, "message" => "Error inserting the bakery!");
    }
} else {
    $response = array("code" => 15, "message" => "Missing parameters!");
}

echo json_encode($response, JSON_PRETTY_PRINT);


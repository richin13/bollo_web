<?php
/**
 *
 * @file          modify.php
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
 * Date: 04/11/15
 * Time: 04:31 PM
 */

include('../../../config.php');

header('Content-type: application/json; charset=utf-8');
$response = array();

$all_set = isset($_GET['id']) && isset($_GET['name']) && isset($_GET['state']) &&
    isset($_GET['city']);

if ($all_set) {
    $bakery_id = $_GET['id'];
    $bakery_name = $_GET['name'];
    $bakery_state = $_GET['state'];
    $bakery_city = $_GET['city'];
    if (edit_bakery($bakery_id, $bakery_name, $bakery_state, $bakery_city)) {
        $response = array("code" => 0, "message" => "Ok!");
    } else {
        $response = array("code" => 1, "message" => "Error editing the bakery!");
    }
} else {
    $response = array("code" => 15, "message" => "Missing parameters!");
}

echo json_encode($response, JSON_PRETTY_PRINT);
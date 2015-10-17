<?php
/**
 *
 * @file          delete.php
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
 * Time: 09:17 PM
 */

include('../../../config.php');

header('Content-type: application/json; charset=utf-8');
$response = array();

$id = isset($_GET['id']);

if ($id) {

    $id = $_GET['id'];
    if (delete_bakery($id)) {
        $response = array("code" => 0, "message" => "Better than expected");
    } else {
        $response = array("code" => 1, "message" => "Couldn't delete bakery");
    }
} else {
    $response = array("code" => 15, "message" => "Missing parameters");
}

echo json_encode($response, JSON_PRETTY_PRINT);
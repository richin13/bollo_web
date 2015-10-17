<?php
/**
 *
 * @file          status.php
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
 * Date: 28/10/15
 * Time: 07:26 PM
 */

include('../../../config.php');

header('Content-type: application/json; charset=utf-8');
$response = array();

$id = isset($_GET['id']);
$progress = isset($_GET['progress']);
$description = isset($_GET['description']);

if ($id && !($progress || $description)) {
    $id = $_GET['id'];
    if (($status = get_status($id))) {
        $response = array('code' => 0, 'message' => "Ok!", 'progress' => $status[0], 'status' => $status[1]);
    } else {
        $response = array('code' => 1, 'message' => "Bakery not found!");
    }
} elseif ($id && $progress && $description) {
    $id = $_GET['id'];
    $progress = $_GET['progress'];
    $description = $_GET['description'];

    if (set_status($id, $progress, $description)) {
        $response = array('code' => 0, 'message' => "Ok");
    } else {
        $response = array('code' => 1, 'message' => "Bakery not found");
    }
} else {
    $response = array('code' => 15, 'message' => "Missing parameters");
}

echo json_encode($response, JSON_PRETTY_PRINT);

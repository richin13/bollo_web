<?php
/**
 *
 * @file          production.php
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
 * Date: 11/11/15
 * Time: 07:45 PM
 */
include('../../../config.php');

header('Content-type: application/json; charset=utf-8');
$response = array();

$id = isset($_GET['id']);
$quantity = isset($_GET['quantity']);
$all = isset($_GET['all']);

if ($id && $quantity) {
    $id = $_GET['id'];
    $quantity = $_GET['quantity'];

    if (get_bakery($id)) {
        add_production($id, $quantity);
        $response = array('code' => 0, 'message' => "Ok");
    } else {
        $response = array('code' => 1, 'message' => "Bakery not found!");
    }
} elseif ($id) {
    $id = $_GET['id'];
    $response = array('code' => 0, 'message' => "Ok", 'data' => get_production($id));
} elseif ($all) {
    $response = array('code' => 0, 'message' => "Ok", 'data' => get_general_production());
} else {
    $response = array('code' => 15, 'message' => "Missing parameters");
}

echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
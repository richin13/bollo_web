<?php
/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 17/10/15
 * Time: 02:19 PM
 */
include('../../../config.php');

header('Content-type: application/json; charset=utf-8');
$response = array();

$id = isset($_GET['id']);
$all = isset($_GET['all']);
$stock = isset($_GET['stock']);

if ($id && !$all && !$stock) {
    $id = $_GET['id'];
    if (($bakery = get_bakery($id))) {
        $response = array('code' => 0, 'message' => "Ok!", 'bakeries' => $bakery);
    } else {
        $response = array('code' => 1, 'message' => "Bakery not found!");
    }
} else if ($id && $stock && !$all) {
    $id = $_GET['id'];
    $stock = $_GET['stock'];
    if (set_stock($id, $stock, isset($_GET['keep']))) {
        $response = array('code' => 0, 'message' => "Ok!");
    } else {
        $response = array('code' => 1, 'message' => "Bakery not found!");
    }
} else if ($all && !$id && !$stock) {
    $response = array('code' => 0, 'message' => "Ok!", 'bakeries' => get_bakery());
} else {
    $response = array('code' => 2, 'message' => "Invalid parameters");
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
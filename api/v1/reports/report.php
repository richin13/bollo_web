<?php
/**
 *
 * @file          report.php
 * @author        ricardo
 * @version       2.1.23
 * @copyright     (c) 2015 Ricardo Madriz
 * @licensing     GNU GPL 2.0
 * @link          http://bollo-server.bitnamiapp.comm
 *
 * This software is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Date: 15/11/15
 * Time: 04:19 PM
 */
include('../../../config.php');

header('Content-type: application/json; charset=utf-8');
$response = array();

$bid = isset($_GET['id']);
$text = isset($_GET['message']);
$dough = isset($_GET['dough']);

if ($bid && $text) {
    $bid = $_GET['id'];
    $text = $_GET['message'];

    if (!$dough) {
        if (add_event_entry(add_parent_entry($bid, $text))) {
            $response = array('code' => 0, 'message' => "Ok");
        } else {
            $response = array('code' => 1, 'message' => "Failed!");
        }
    } else {
        $dough = $_GET['dough'];
        if (add_problem_entry(add_parent_entry($bid, $text), $dough)) {
            $response = array('code' => 0, 'message' => "Ok");
        } else {
            $response = array('code' => 1, 'message' => "Failed!");
        }
    }
} else {
    $response = array('code' => 15, 'message' => "Missing parameters");
}

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
<?php
/**
 *
 * @file          logbook.php
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
 * Date: 22/10/15
 * Time: 10:42 PM
 */

include('../../../config.php');

header('Content-type: application/json; charset=utf-8');
$response = array();

$bakery = isset($_GET['bakery']) && is_numeric($_GET['bakery']);
$problems = isset($_GET['problem']);
$events = isset($_GET['event']);
if ($events && !($bakery || $problems)) {
    $response = array('code' => 0, 'message' => "Ok!", 'events' => log_events());
} elseif (($events && $bakery) && !$problems) {
    $bakery_id = $_GET['bakery'];
    $response = array('code' => 0, 'message' => "Ok!", 'events' => log_events($bakery_id));
} elseif ($problems && !($bakery || $events)) {
    $response = array('code' => 0, 'message' => "Ok!", 'problems' => log_problems());
} elseif (($problems && $bakery) && !$events) {
    $bakery_id = $_GET['bakery'];
    $response = array('code' => 0, 'message' => "Ok!", 'problems' => log_problems($bakery_id));
} else {
    $response = array("code" => 15, "message" => "Missing parameters!");
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);

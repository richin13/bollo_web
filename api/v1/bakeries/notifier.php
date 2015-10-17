<?php
/**
 *
 * @file          notifier.php
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
 * Date: 15/11/15
 * Time: 12:51 PM
 */

define("NEED_TELEGRAM", true);

include('../../../config.php');

header('Content-type: application/json; charset=utf-8');
$response = array();

$all_set = isset($_GET['token']) && isset($_GET['chatid']) && isset($_GET['msg']);

if ($all_set) {
    $token = $_GET['token'];
    $chat_id = $_GET['chatid'];
    $message = $_GET['msg'];

    $bot = new TelegramBot\Api\BotApi($token);
    $bot->sendMessage($chat_id, $message);

    $response = array('code' => 0, 'message' => "Ok");
} else {
    $response = array('code' => 15, 'message' => "Missing parameters");
}

echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

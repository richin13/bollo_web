<?php
/**
 * Created by PhpStorm.
 * User: ricardo
 * Date: 17/10/15
 * Time: 02:19 PM
 */
include('../../../config.php');
require_once(DIR_BOLLO . '/core/query.php');

header('Content-type: application/json');
$response = array();

if(isset($_GET['api_token'])) {
    $token = $_GET['api_token'];

    if(check_api_token($token)) {
        $id = isset($_GET['id']);
        $all = isset($_GET['all']);
        $stock = isset($_GET['stock']);

        if($id && !$all && !$stock) {
            //Identification request!
        } else if($id && $stock && !$all) {
            //update stock - returns the stock
        } else if($all && !$id && !$stock) {
            //all the bakeries
        }

    }else {
        //invalid api token
    }
} else {
    //missing api token
}

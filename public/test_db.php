<?php
///**
// * Created by PhpStorm.
// * User: ricardo
// * Date: 11/10/15
// * Time: 02:47 PM
// */
//include("../core/config.php");
//include(DIR_BOLLO . "/core/query.php");
//
//$conn = BolloConn::getConn();
//
//if(!$conn) {
//    echo "Error connecting to the database!";
//    echo "<br>";
//} else {
//    echo "Connected!";
//    echo "<br>";
//    $sql = "SELECT * FROM bollo_api;";
//    $res = pg_query($conn, $sql);
//
//    if($res) {
//        echo "Received data!";
//        echo "<br>";
//        while ($row = pg_fetch_row($res)) {
//            echo "ID: $row[0]  Token: $row[1]";
//            echo "<br />\n";
//        }
//    } else {
//        echo "No data received!";
//        echo "<br>";
//        var_dump($res);
//    }
//}


<?php

/**
 * Class BolloConn handles the database connection!
 */
class BolloConn {
    private static $conn = NULL;

    public static function getConn() {
        $host = "104.154.49.207";
        $user = "postgres";
        $pw = "W3aS28yt";
        $db_name = "bollo_test";

        $conn_string = "host='$host' port=5432 dbname='$db_name' user='$user' password='$pw'";
        BolloConn::$conn = pg_connect($conn_string);
        if (!BolloConn::$conn) {
            return NULL;
        }

        return BolloConn::$conn;
    }
}

?>

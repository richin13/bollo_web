<?php

/**
 * Class BolloConn handles the database connection!
 */
class BolloConn {
    public static function getConn() {
        $host = "104.154.49.207";
        $user = "postgres";
        $pw = "W3aS28yt";
        $db_name = "bollo_testing_final";

        $conn_string = "host=$host port=5432 dbname=$db_name user=$user password=$pw";
        $conn = pg_connect($conn_string);

        if ($conn === FALSE) {
            die("Falló la conexión con la DB");
        } else {
            return $conn;
        }
    }
}


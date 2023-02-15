<?php
    function connectionSql(){
        // Connect to the database
        $conn = pg_connect("host=db dbname=estrakio user=estrakio password=bonjour");
        // Show the client and server versions
        //print_r(pg_version($conn));
        return $conn;
    }
?>
<?php
    //upload to github
    $hostname = "transferin.database.windows.net";
    $username = "transferin";
    $pass = "mr_Condong1105";
    $dbname = "transferin";

    try {
        $connect = new PDO("sqlsrv:server = $hostname; Database = $dbname", $username, $pass);
        $connect->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch(Exception $e) {
        echo "Failed Connect Database : " . $e;
    }

    //local db
    // $hostname = "localhost";
    // $username = "root";
    // $pass = "";
    // $dbname = "transferin";

    // $connect = mysqli_connect($hostname, $username, $pass, $dbname);

    // if (mysqli_connect_errno()){
    //     echo "Connect database failed : ".mysqli_connect_errno();
    // }
    
?>
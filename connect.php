<?php
    //upload to github
    // $hostname = "transferin.database.windows.net";
    // $username = "transferin";
    // $pass = "mr_Condong1105";
    // $dbname = "transferin";

    // try {
    //     //$connect = new PDO("sqlsrv:server = $hostname; Database = $dbname", $username, $pass);
        
    //     $options = array(
    //         "Database" => $dbname,
    //         "UID" => $username,
    //         "PWD" =>$pass
    //     );
    //     $connect = sqlsrv_connect($hostname, $options);
    //     $connect->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    // } catch(Exception $e) {
    //     echo "Failed Connect Database : " . $e;
    // }

    try {
        $conn = new PDO("sqlsrv:server = tcp:transferin.database.windows.net,1433; Database = transferin", "transferin", "mr_Condong1105");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
        print("Error connecting to SQL Server.");
        die(print_r($e));
    }
    
?>
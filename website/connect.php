<?php
    $serverName = "team-3-server.database.windows.net"; // update me
    $connectionOptions = array(
        "Database" => "team-3-db", // update me
        "Uid" => "website", // update me
        "PWD" => "Password1" // update me
    );
    //Establishes the connection
    $conn = sqlsrv_connect($serverName, $connectionOptions);
?>

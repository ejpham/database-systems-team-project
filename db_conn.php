<?php
$serverName = "team-3-server.database.windows.net\\sqlexpress";
$connectionInfo = array("Database" => "team-3-db", "UID" => "website", "PWD" => "Password1");
$conn = sqlsrv_connect($serverName, $connectionInfo);

if ($conn) {
    echo "Connection established.<br/>";
}
else {
    echo "Connection could not be established.<br/>";
    die(print_r(sqlsrv_errors(), true));
}
?>

<?php
define('serverName', 'database-cosc-3380-team-3.cp6t5hjmtlcw.us-east-1.rds.amazonaws.com');
define('userName', 'admin');
define('password', 'Password1');
define('dbName', 'WebLogins');
$conn_WebLogins = mysqli_connect(serverName, userName, password, dbName);

if (!$conn_WebLogins) {
    echo "Connection to WebLogins Schema could not be established.";
    die(print_r(mysqli_error(), true));
}
?>

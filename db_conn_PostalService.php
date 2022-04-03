<?php
define('serverName', 'database-cosc-3380-team-3.cp6t5hjmtlcw.us-east-1.rds.amazonaws.com');
define('userName', 'admin');
define('password', 'Password1');
define('dbName', 'PostalService');
$conn = mysqli_connect(serverName, userName, password, dbName);

if ($conn) {
    echo "Connection to PostalService Schema established.<br/>";
}
else {
    echo "Connection to PostalService Schema could not be established.<br/>";
    die(print_r(mysqli_error(), true));
}
?>

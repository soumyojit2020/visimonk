<?php
/* Database credentials. Assuming you are running MySQL*/
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'bct_vms');
define('DB_PASSWORD', 'BlinkingCursors@1213');
define('DB_NAME', 'bct_vms');

/* Attempt to connect to MySQL database */
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($conn === false){
  die("ERROR: Could not connect. " . $mysqli->connect_error);
}

//including the helper file
include 'helper.php';
?>

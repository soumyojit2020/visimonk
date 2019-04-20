<?php
/* Database credentials. Assuming you are running MySQL*/
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'user_name');
define('DB_PASSWORD', 'pass_word');
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

<?php
  require_once 'include/dbConfig.php';
  checkLogin();

  if(isset($_GET) && !empty($_GET)){
    $port_id = clean($_GET['port_id']);
    $sql_port_update = "UPDATE port SET active=1 WHERE port_id=$port_id AND account_id='$accountId'";
    $query_port = mysqli_query($conn, $sql_port_update);
    header('location: port_view.php');
  }
?>

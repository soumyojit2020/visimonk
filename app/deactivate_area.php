<?php
  require_once 'include/dbConfig.php';
  checkLogin();

  if(isset($_GET) && !empty($_GET)){
    $area_id = clean($_GET['area_id']);
    $sql_area_update = "UPDATE area SET active=0 WHERE area_id=$area_id AND account_id='$accountId'";
    $query_area = mysqli_query($conn, $sql_area_update);
    $sql_port_update = "UPDATE port SET active=0 WHERE area_id=$area_id AND account_id='$accountId'";
    $query_port = mysqli_query($conn, $sql_port_update);
    header('location: area_view.php');
  }
?>

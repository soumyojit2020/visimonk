<?php
  require_once 'include/dbConfig.php';
  checkLogin();

  if(isset($_GET) && !empty($_GET)){
    $floor_id = clean($_GET['floor_id']);
    $sql_area_update = "UPDATE area SET active=1 WHERE floor_id=$floor_id AND account_id='$accountId'";
    $query_area = mysqli_query($conn, $sql_area_update);
    $sql_floor_update = "UPDATE `floor` SET active=1 WHERE floor_id=$floor_id AND account_id='$accountId'";
    $query_floor = mysqli_query($conn, $sql_floor_update);
    $sql_port_update = "UPDATE port SET active=1 WHERE floor_id=$floor_id AND account_id='$accountId'";
    $query_port = mysqli_query($conn, $sql_port_update);
    header('location: floor_view.php');
  }
?>

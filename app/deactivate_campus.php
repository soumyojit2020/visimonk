<?php
  require_once 'include/dbConfig.php';
  checkLogin();

  if(isset($_GET) && !empty($_GET)){
    $campus_id = clean($_GET['campus_id']);
    $sql_campus_update = "UPDATE campus SET active=0 WHERE campus_id=$campus_id AND account_id='$accountId'";
    $query_campus = mysqli_query($conn, $sql_campus_update);
    $sql_building_update = "UPDATE building SET active=0 WHERE campus_id=$campus_id AND account_id='$accountId'";
    $query_building = mysqli_query($conn, $sql_building_update);
    $sql_area_update = "UPDATE area SET active=0 WHERE campus_id=$campus_id AND account_id='$accountId'";
    $query_area = mysqli_query($conn, $sql_area_update);
    $sql_floor_update = "UPDATE `floor` SET active=0 WHERE campus_id=$campus_id AND account_id='$accountId'";
    $query_floor = mysqli_query($conn, $sql_floor_update);
    $sql_port_update = "UPDATE port SET active=0 WHERE campus_id=$campus_id AND account_id='$accountId'";
    $query_port = mysqli_query($conn, $sql_port_update);
    header('location: campus_view.php');
  }
?>

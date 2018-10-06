<?php
  require_once 'include/dbConfig.php';
  checkLogin();

  if(isset($_GET) && !empty($_GET)){
    $building_id = clean($_GET['building_id']);
    $sql_building_update = "UPDATE building SET active=1 WHERE building_id=$building_id AND account_id='$accountId'";
    $query_building = mysqli_query($conn, $sql_building_update);
    $sql_area_update = "UPDATE area SET active=1 WHERE building_id=$building_id AND account_id='$accountId'";
    $query_area = mysqli_query($conn, $sql_area_update);
    $sql_floor_update = "UPDATE `floor` SET active=1 WHERE building_id=$building_id AND account_id='$accountId'";
    $query_floor = mysqli_query($conn, $sql_floor_update);
    $sql_port_update = "UPDATE port SET active=1 WHERE building_id=$building_id AND account_id='$accountId'";
    $query_port = mysqli_query($conn, $sql_port_update);
    header('location: building_view.php');
  }
?>

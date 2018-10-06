<?php
  require_once 'dbConfig.php';
  checkLogin();

  if(isset($_POST['get_building']) && !empty($_POST['get_building'])){
    $campus_id = clean($_POST['get_building']);
    $sql_fetch_building = "SELECT * FROM building WHERE campus_id = ? AND account_id = ?";
    if($stmt_fetch_building = mysqli_prepare($conn, $sql_fetch_building)){
      mysqli_stmt_bind_param($stmt_fetch_building, "ss", $param_campus_id, $param_account_id);
      $param_campus_id = $campus_id;
      $param_account_id = $accountId;
      if(mysqli_stmt_execute($stmt_fetch_building)){
        $result_fetch_building = mysqli_stmt_get_result($stmt_fetch_building);
        while($row_fetch_building = mysqli_fetch_array($result_fetch_building)){
          echo '<option value="'.$row_fetch_building['building_id'].'">'.$row_fetch_building['building_description'].'</option>';
        }
      }
    }
  }
?>

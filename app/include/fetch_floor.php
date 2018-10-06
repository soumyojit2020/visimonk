<?php
  require_once 'dbConfig.php';
  checkLogin();

  if(isset($_POST['get_floor']) && !empty($_POST['get_floor'])){
    $building_id = clean($_POST['get_floor']);
    $sql_fetch_floor = "SELECT * FROM floor WHERE building_id = ? AND account_id = ?";
    if($stmt_fetch_floor = mysqli_prepare($conn, $sql_fetch_floor)){
      mysqli_stmt_bind_param($stmt_fetch_floor, "ss", $param_building_id, $param_account_id);
      $param_building_id = $building_id;
      $param_account_id = $accountId;
      if(mysqli_stmt_execute($stmt_fetch_floor)){
        $result_fetch_floor = mysqli_stmt_get_result($stmt_fetch_floor);
        while($row_fetch_floor = mysqli_fetch_array($result_fetch_floor)){
          echo '<option value="'.$row_fetch_floor['floor_id'].'">'.$row_fetch_floor['floor_description'].'</option>';
        }
      }
    }
  }
?>

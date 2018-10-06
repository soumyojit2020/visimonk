<?php
  require_once 'dbConfig.php';
  checkLogin();

  if(isset($_POST['get_area']) && !empty($_POST['get_area'])){
    $floor_id = clean($_POST['get_area']);
    $sql_fetch_area = "SELECT * FROM area WHERE floor_id = ? AND account_id = ?";
    if($stmt_fetch_area = mysqli_prepare($conn, $sql_fetch_area)){
      mysqli_stmt_bind_param($stmt_fetch_area, "ss", $param_floor_id, $param_account_id);
      $param_floor_id = $floor_id;
      $param_account_id = $accountId;
      if(mysqli_stmt_execute($stmt_fetch_area)){
        $result_fetch_area = mysqli_stmt_get_result($stmt_fetch_area);
        while($row_fetch_area = mysqli_fetch_array($result_fetch_area)){
          echo '<option value="'.$row_fetch_area['area_id'].'">'.$row_fetch_area['area_description'].'</option>';
        }
      }
    }
  }
?>

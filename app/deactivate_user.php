<?php
  require_once 'include/dbConfig.php';
  checkLogin();

  if(isset($_GET) && !empty($_GET)){
    $user_id = clean($_GET['user_id']);
    $sql_user_update = "UPDATE user SET active=0 WHERE user_id=$user_id AND account_id='$accountId'";
    $query_user_update = mysqli_query($conn,$sql_user_update);
    header('location: users_view.php');
  }
?>

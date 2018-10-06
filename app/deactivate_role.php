<?php
  require_once 'include/dbConfig.php';
  checkLogin();

  if(isset($_GET) && !empty($_GET)){
    $role_id = clean($_GET['role_id']);
    $sql_role_update = "UPDATE role SET active=0 WHERE role_id=$role_id AND account_id='$accountId'";
    $query_role_update = mysqli_query($conn,$sql_role_update);
    header('location: roles_view.php');
  }
?>

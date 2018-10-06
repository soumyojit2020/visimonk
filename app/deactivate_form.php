<?php
  require_once 'include/dbConfig.php';
  checkLogin();

  if(isset($_GET) && !empty($_GET)){
    $form_id = clean($_GET['form_id']);
    $sql_form_update = "UPDATE form_structure SET active=0 WHERE form_id=$form_id AND account_id='$accountId'";
    $query_form_update = mysqli_query($conn,$sql_form_update);
    header('location: form_edit_view.php');
  }
?>

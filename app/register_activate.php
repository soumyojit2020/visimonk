<?php

//include db connection
require_once 'include/dbConfig.php';

  if($_GET){
    $email = clean($_GET['e']);
    $submitted_token = clean($_GET['tc']);
    print_r($_GET);

    $sql_token = "SELECT token_code FROM user WHERE user_status = 'pending' AND email=? ";
    if($stmt_token = mysqli_prepare($conn, $sql_token)){
      mysqli_stmt_bind_param($stmt_token,"s", $param_email);
      $param_email = $email;
      if(mysqli_stmt_execute($stmt_token)){
        $result_token = mysqli_stmt_get_result($stmt_token);
        $row_token = mysqli_fetch_array($result_token);
        $token_code = $row_token['token_code'];
        if($submitted_token != $token_code){
          header('Location: login_view.php?message=invalid');
        }
        if($submitted_token == $token_code){
          $sql_update_status = "UPDATE user SET user_status = 'confirmed' WHERE email=?";
          if($stmt_update_status = mysqli_prepare($conn, $sql_update_status)){
            mysqli_stmt_bind_param($stmt_update_status, "s", $param_email);
            $param_email = $email;
            if(mysqli_stmt_execute($stmt_update_status)){
              header('location: login_view.php?message=success');
            }
          }
        }
      }
    }
  }
?>

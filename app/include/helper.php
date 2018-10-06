<?php

  //function to display errors
  function display_errors($errors){
    $display = '<ul class="bg-danger">';
    foreach ($errors as $error) {
      $display .= '<li class="text-danger">' . $error . '</li>';
    }
    $display .= '</ul>';
    return $display;
  }

  function display_success($success){
    $display = '<ul class="bg-success">';
    foreach ($success as $error) {
      $display .= '<li class="text-success">' . $error . '</li>';
    }
    $display .= '</ul>';
    return $display;
  }


  //function to sanitize input
  function clean($input){
    $input = htmlspecialchars($input, ENT_QUOTES);
    return $input;
  }

  //function to check login
  function checkLogin(){
    session_start();
    // If session variable is not set it will redirect to login page
    if(!isset($_SESSION['email']) || empty($_SESSION['email'])){
      header("location: login_view.php");
      exit;
    }

    if(isset($_SESSION['email']) || !empty($_SESSION['email'])){
      //pull up user details, roles and permissions
      $email = clean($_SESSION['email']);
      $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
      $sql_user = "SELECT user_id, account_id, user_name, email, user_status, active FROM user WHERE email = ?";
      if($stmt = mysqli_prepare($conn, $sql_user)){
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        $param_email = $email;
        if(mysqli_stmt_execute($stmt)){
          $result_user = mysqli_stmt_get_result($stmt);
          if(mysqli_num_rows($result_user) == 1){
            $row = mysqli_fetch_array($result_user, MYSQLI_ASSOC);
            $user_status = $row['user_status'];
            if($user_status == 'pending'){
              header('location: login_view.php?message=pending');
            }
            $user_active = $row['active'];
            if($user_active != 1){
              header('location: login_view.php?message=inactive');
            }
            global $userId;
            $userId = $row ['user_id'];
            global $accountId;
            $accountId = $row['account_id'];
            global $userName;
            $userName = $row ['user_name'];
            global $userEmail;
            $userEmail = $row ['email'];

          }
        }
      }
      //role Start
      $sql_role = "SELECT a.role_id, b.role_description FROM role_user a JOIN role b ON a.role_id = b.role_id WHERE a.user_id = ? ";
      if($stmt_role = mysqli_prepare($conn, $sql_role)){
        mysqli_stmt_bind_param($stmt_role, "s", $param_role);
        $param_role = $userId;
        if(mysqli_stmt_execute($stmt_role)){
          $result_role = mysqli_stmt_get_result($stmt_role);
          if(mysqli_num_rows($result_role) == 1){
            $row_role = mysqli_fetch_array($result_role, MYSQLI_ASSOC);
            global $role_id;
            $role_id = $row_role['role_id'];
            global $role_description;
            $role_description = $row_role['role_description'];
          }
        }
      }
      //role End
      //permissions Start
      global $permission;
      $permission = array();
      $sql_permission = "SELECT permission.permission_description FROM role_permission JOIN permission
      ON role_permission.permission_id = permission.permission_id WHERE role_permission.role_id = ?";
      if($stmt_permission = mysqli_prepare($conn, $sql_permission)){
        mysqli_stmt_bind_param($stmt_permission, "s", $param_permission);
        $param_permission = $role_id;
        if(mysqli_stmt_execute($stmt_permission)){
          $result_permission = mysqli_stmt_get_result($stmt_permission);
          if(mysqli_num_rows($result_permission) >= 1){
            while($row_permission = mysqli_fetch_array($result_permission, MYSQLI_ASSOC)){
              $permission[$row_permission["permission_description"]] = $row_permission["permission_description"];
            }
          }
        }
      }//permissions end
    }
    return $userId;
    return $accountId;
    return $userName;
    return $userEmail;
    return $role_id;
    return $role_description;
    return $permission;
  }//function check login



?>

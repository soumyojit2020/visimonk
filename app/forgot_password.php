<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';

	$errors = array();
  if(isset($_GET) && !empty($_GET)){
    $email = clean($_GET['e']);
    $token_code = clean($_GET['tc']);
    $sql_token_code = "SELECT token_code FROM user WHERE email=?";
    if($stmt_token_code = mysqli_prepare($conn, $sql_token_code)){
      mysqli_stmt_bind_param($stmt_token_code,"s", $param_email);
      $param_email = $email;
      if(mysqli_stmt_execute($stmt_token_code)){
        $result_token_code = mysqli_stmt_get_result($stmt_token_code);
        if(mysqli_num_rows($result_token_code) == 0){
          header('location: invalid_link.php');
        }
        $row_token_code = mysqli_fetch_array($result_token_code);
        $returned_token_code = $row_token_code['token_code'];
        if($returned_token_code != $token_code){
          header('location: invalid_link.php');
        }
      }
  }
}

if(isset($_POST) && !empty($_POST)){
	$email = clean($_POST['email']);
	$password = clean($_POST['password']);
	$confirmPassword = clean($_POST['confirm_password']);

if(empty($password || $confirmPassword)){
	$errors[] .= 'All fields are required';
}
if(!empty($confirmPassword)){
	if($password != $confirmPassword){
		$errors[] .= 'Passwords do not match';
	}
}

$password = password_hash($password, PASSWORD_DEFAULT);

if(empty($errors)){
	$sql_password_update = "UPDATE user SET password='$password' WHERE email='$email'";
	if($query1 = mysqli_query($conn, $sql_password_update)){
	  header("location: login_view.php?message=password_reset");
		}
	}
}

?>
<body class="login">
  <div>
    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <form action="forgot_password.php" method="POST">
            <h1>Enter New Password</h1>
						<div>

						</div>
						<div>
							<?php
								if(!empty($errors)){
									echo display_errors($errors);
								}
							?>
						</div>
            <input type="hidden" name="email" value="<?=$email?>"/>
            <div>
              <input type="" class="form-control" name="password" placeholder="Password" required="" />
            </div>
            <br>
            <div>
              <input type="" class="form-control" name="confirm_password" placeholder="Confirm Password" required="" />
            </div>
            <br>
            <div>
              <input type="submit" class="btn btn-default submit" value="Submit" />
            </div>

            <div class="clearfix"></div>

            <div class="separator">
              <p class="change_link">New to site?
                <a href="register_view.php" class="to_register"> Create Account </a>
              </p>

              <div class="clearfix"></div>
              <br />

              <div>
                <h1><img src="images/logoImage.png"/><img src="images/logoText.png"/></h1>
                <p>©2018 All Rights Reserved. <a href="http://blinkingcursors.in">Blinking Cursors<a/>
                  <br>
                  <a href="#">Terms & Privacy</a></p>
              </div>
            </div>
          </form>
        </section>
      </div>
    </div>
  </div>
<?php
	include 'include/script.php';
?>

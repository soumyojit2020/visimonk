<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';

	$errors = array();
  if(isset($_POST) && !empty($_POST)){
    $email = clean($_POST['email']);
    if(empty($email)){
      $errors[] .= 'E-mail is mandatory!';
    }
    if(empty($errors)){
      $sql_registered_user = "SELECT * FROM user WHERE email=?";
      if($stmt_registered_user = mysqli_prepare($conn, $sql_registered_user)){
        mysqli_stmt_bind_param($stmt_registered_user,"s", $param_email);
        $param_email = $email;
        if(mysqli_stmt_execute($stmt_registered_user)){
          $result_registered_user = mysqli_stmt_get_result($stmt_registered_user);
          if(mysqli_num_rows($result_registered_user) == 0){
            $errors[] .= $email. ' is not registered!';
          }
          $row_registered_user = mysqli_fetch_array($result_registered_user);
          $row_registered_user_email = $row_registered_user['email'];
          $to_email = "$row_registered_user_email";
          $to = "$to_email";
          $subject = 'VisiMonk Password Reset Link!';
          $message = 'Dear '.$row_registered_user['user_name'].",". "\r\n"."\r\n".
          'Please click on the below link to reset your password!'. "\r\n".
          'app.visimonk.com/forgot_password.php?e='.$row_registered_user['email'].'&tc='.$row_registered_user['token_code']. "\r\n"."\r\n".
          'Regards,'. "\r\n".
          'Team VisiMonk'. "\r\n";
          $headers = 'From: forgot@visimonk.com' . "\r\n" .
           'Reply-To: support@visimonk.com' . "\r\n" .
           'X-Mailer: PHP/' . phpversion();
           mail($to, $subject, $message, $headers);
					 header('location: login_view.php?message=reset_link');
        }
      }

    }


  }

?>
<body class="login">
  <div>
    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <form action="forgot_password_view.php" method="POST">
            <h1>Enter your e-mail</h1>
						<div>

						</div>
						<div>
							<?php
								if(!empty($errors)){
									echo display_errors($errors);
								}
							?>
						</div>
            <div>
              <input type="email" class="form-control" name="email" placeholder="Email" required="" />
            </div>
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

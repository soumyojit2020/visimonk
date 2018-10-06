<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	$success = array();
	$errors = array();
	if($_GET){
		$status = $_GET['message'];

		if($status == "register"){
		$success[] .= "Registered succesfully. Activation mail sent to your email!";
		}

		if($status == "invalid"){
		$errors[] .= "Invalid Code. Please contact support!";
		}

		if($status == "success"){
		$success[] .= "Activation complete. Login and enjoy VisiMonk!";
		}

		if($status == "pending"){
		$errors[] .= "Activation Pending. Please check your inbox!";
		}

		if($status == "inactive"){
		$errors[] .= "User inactive. Please contact your admin!";
		}

		if($status == "change_password"){
		$success[] .= "Password Changed. Please login with new password!";
		}

		if($status == "reset_link"){
		$success[] .= "Reset link sent to your inbox. Please check!";
		}

		if($status == "password_reset"){
		$success[] .= "Password reset succesfully. Please login with new password!";
		}

	}

	if(isset($_POST['login']) && !empty($_POST['login'])){

		//gather/clean post data and assign to variables
		$email = $_POST['email'];
		$password = $_POST['password'];

		//validate all input contains data
		if(empty($email || $password)){
			$errors[] .= 'All fields are required';
		}
		if(empty($errors)){
		// first validate if email exists
		if(!empty($email)){
			//prepare a select statement
			$sql = "SELECT email, password FROM user WHERE email = ?";
			if($stmt = mysqli_prepare($conn, $sql)){
				//bind variable to prepared statement as parameter
				mysqli_stmt_bind_param($stmt, "s", $email);
				//attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){
					/*store results*/
					mysqli_stmt_store_result($stmt);
					if(mysqli_stmt_num_rows($stmt) == 1){
						//validate password
						//bind results variable
						mysqli_stmt_bind_result($stmt, $email, $hashed_password);
						if(mysqli_stmt_fetch($stmt)){
							if(password_verify($password, $hashed_password)){
								/*password is correct so start a new session
								save the user name in session*/
								session_start();
								$_SESSION['email'] = $email;
								header('location: index.php');
							}else{
								$errors[] .= 'Email-Password do not match!';
							}
						}//fetch statement
					} else{
						$errors[] .= $email . ' is not an user.' . '<a href="register_view.php">Register Here</a>';
					}
				}
			}
			//close statement
			mysqli_stmt_close($stmt);
		}//email validation
	}//if empty errors
	}//main post if
?>
<body class="login">
  <div>
    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <form action="login_view.php" method="POST">
            <h1>Login</h1>
						<div>

						</div>
						<div>
							<?php
								if(!empty($success)){
									echo display_success($success);
								}
							?>
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
              <input type="password" class="form-control" name="password" placeholder="Password" required="" />
            </div>
            <div>
              <input type="submit" class="btn btn-default submit" name="login" value="Login" />
              <a class="reset_pass" href="forgot_password_view.php">Lost your password?</a>
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

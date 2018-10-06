<?php
	include 'include/head.php';
	//include db connection
	require_once 'include/dbConfig.php';


	$errors = array();

	  if(isset($_POST['register']) && !empty($_POST['register'])){

			//gather/clean post data and assign to variables
			$fullName = clean($_POST['fullName']);
			$companyName = clean($_POST['companyName']);
			$phoneNumber = clean($_POST['phoneNumber']);
			$email = clean($_POST['email']);
			$password = clean($_POST['password']);
			$confirmPassword = clean($_POST['confirmPassword']);

	    //validate all input contains data
			if(empty($fullName || $companyName || $phoneNumber || $email || $password || $confirmPassword)){
				$errors[] .= 'All fields are required';
			}

			//validate if email already exists
			if(!empty($email)){
				//prepare a select statement
				$sql = "SELECT email FROM user WHERE email = ?";
				if($stmt = mysqli_prepare($conn, $sql)){
					//bind variable to prepared statement as parameter
					mysqli_stmt_bind_param($stmt, "s", $email);
					//attempt to execute the prepared statement
					if(mysqli_stmt_execute($stmt)){
						/*store results*/
						mysqli_stmt_store_result($stmt);
						if(mysqli_stmt_num_rows($stmt) == 1){
							$errors[] .= $email. ' already exists';
						} else{
							$email = clean($_POST['email']);
						}
					}
				}
				//close statement
				mysqli_stmt_close($stmt);
			}//email validation

			//validate if phone already exists
			if(!empty($phoneNumber)){
				//prepare a select statement
				$sql = "SELECT phone_number FROM user WHERE phone_number = ?";
				if($stmt = mysqli_prepare($conn, $sql)){
					//bind variable to prepared statement as parameter
					mysqli_stmt_bind_param($stmt, "s", $phoneNumber);
					//attempt to execute the prepared statement
					if(mysqli_stmt_execute($stmt)){
						/*store results*/
						mysqli_stmt_store_result($stmt);
						if(mysqli_stmt_num_rows($stmt) == 1){
							$errors[] .= $phoneNumber. ' already exists';
						} else{
							$phoneNumber = clean($_POST['phoneNumber']);
						}
					}
				}
				//close statement
				mysqli_stmt_close($stmt);
			}//phone validation

			//validate confirm Password
			if(!empty($confirmPassword)){
				if($password != $confirmPassword){
					$errors[] .= 'Passwords do not match';
				}
			}//validate confirm Password

			//insert data if no errors found
			if(empty($errors)){
				//generate account ID
				$accountId = md5($companyName.microtime());

				//prepare statement to insert into Account table
				$sqlAccount = "INSERT INTO account(account_id, account_name) VALUES(?, ?)";
				if($stmtAccount = mysqli_prepare($conn, $sqlAccount)){
					//bind variables to the prepared statement as parameters
					mysqli_stmt_bind_param($stmtAccount, "ss", $param_accountId, $param_accountName);
					//set parameters
					$param_accountId = $accountId;
					$param_accountName = $companyName;
					//attempt to execute the statement
					if(!mysqli_stmt_execute($stmtAccount)){
						echo 'Something went wrong, please try again';
					}
				}
				//close statement
				mysqli_stmt_close($stmtAccount);

				//prepare statement to insert into User Table
				//generate token code
				$tokenCode = md5(uniqid(rand()));
				$userStatus = 'pending';
				$sqlUser = "INSERT INTO user(account_id, user_name, phone_number, email, password, user_status, token_code)
				VALUES(?, ?, ?, ?, ?, ?, ?)";
				if($stmtUser = mysqli_prepare($conn, $sqlUser)){
				//bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmtUser, "sssssss", $param_accountId, $param_userName, $param_phoneNumber, $param_email, $param_password, $param_userStatus, $param_tokenCode);
				//set parameters
				$param_accountId = $accountId;
				$param_userName = $fullName;
				$param_phoneNumber = $phoneNumber;
				$param_email = $email;
				$param_password = password_hash($password, PASSWORD_DEFAULT);
				$param_userStatus = $userStatus;
				$param_tokenCode = $tokenCode;

				if(mysqli_stmt_execute($stmtUser)){

					$sql_user_id = "SELECT user_id FROM user WHERE email=? AND account_id=?";
				  if($stmt_user_id = mysqli_prepare($conn, $sql_user_id)){
				    mysqli_stmt_bind_param($stmt_user_id, "ss", $param_email, $param_account_id);
				    $param_email = $email;
				    $param_account_id = $accountId;
				    if(mysqli_stmt_execute($stmt_user_id)){
				      $result_user_id = mysqli_stmt_get_result($stmt_user_id);
				      $row_user_id = mysqli_fetch_array($result_user_id, MYSQLI_ASSOC);
				      $user_id = $row_user_id['user_id'];
				    }
				  }


					$sql_role_insert = "INSERT INTO role (role_description, account_id) VALUES(?, ?)";
		      if($stmt_role_insert = mysqli_prepare($conn, $sql_role_insert)){
		        mysqli_stmt_bind_param($stmt_role_insert, "ss", $param_role_description, $param_account_id);
		        $param_role_description = 'Admin';
		        $param_account_id = $accountId;
		        if(mysqli_stmt_execute($stmt_role_insert)){
		        }
		      }

					$sql_role_processor = "INSERT INTO role (role_description, account_id) VALUES(?, ?)";
          if($stmt_role_processor = mysqli_prepare($conn, $sql_role_processor)){
            mysqli_stmt_bind_param($stmt_role_processor, "ss", $param_role_description, $param_account_id);
            $param_role_description = 'Processor';
            $param_account_id = $accountId;
            if(mysqli_stmt_execute($stmt_role_insert)){
              $sql_role_id_admin = "SELECT role_id FROM role WHERE role_description='Admin' AND account_id=?";
              if($stmt_role_id_admin = mysqli_prepare($conn, $sql_role_id_admin)){
                mysqli_stmt_bind_param($stmt_role_id_admin, "s", $param_account_id);
                $param_account_id = $accountId;
                if(mysqli_stmt_execute($stmt_role_id_admin)){
                  $result_role_id_admin = mysqli_stmt_get_result($stmt_role_id_admin);
                  $row_role_id_admin = mysqli_fetch_array($result_role_id_admin, MYSQLI_ASSOC);
                  $role_id_admin = $row_role_id_admin['role_id'];
                }
              }
            }
          }

					$sql_admin_permission = "INSERT INTO role_permission (role_id, permission_id) VALUES($role_id_admin,1),
					($role_id_admin,2),($role_id_admin,3),($role_id_admin,4),($role_id_admin,5),($role_id_admin,6),($role_id_admin,7),
					($role_id_admin,8),($role_id_admin,9),($role_id_admin,10),($role_id_admin,11),($role_id_admin,12),($role_id_admin,13),
					($role_id_admin,14),($role_id_admin,15),($role_id_admin,16),($role_id_admin,17),($role_id_admin,18),($role_id_admin,19),
					($role_id_admin,20),($role_id_admin,21),($role_id_admin,22),($role_id_admin,23),($role_id_admin,24),($role_id_admin,25),
					($role_id_admin,26),($role_id_admin,27),($role_id_admin,28),($role_id_admin,29),($role_id_admin,30)";
					if($query_admin_permission = mysqli_query($conn, $sql_admin_permission)){
						$sql_role_id_processor = "SELECT role_id FROM role WHERE role_description='Processor' AND account_id=?";
						if($stmt_role_id_processor = mysqli_prepare($conn, $sql_role_id_processor)){
							mysqli_stmt_bind_param($stmt_role_id_processor, "s", $param_account_id);
							$param_account_id = $accountId;
							if(mysqli_stmt_execute($stmt_role_id_processor)){
								$result_role_id_processor = mysqli_stmt_get_result($stmt_role_id_processor);
								$row_role_id_processor = mysqli_fetch_array($result_role_id_processor, MYSQLI_ASSOC);
								$role_id_processor = $row_role_id_processor['role_id'];
							}
						}
					}



					$sql_processor_permission = "INSERT INTO role_permission (role_id, permission_id) VALUES($role_id_processor,23)";
					if($query_processor_permission = mysqli_query($conn, $sql_processor_permission)){
						$sql_role_assign = "INSERT INTO role_user (user_id, role_id) VALUES($user_id, $role_id_admin)";
						if($query_role_assign = mysqli_query($conn, $sql_role_assign)){
							$sql_update_hq = "INSERT INTO hq (account_id) VALUES('$accountId')";
							if($query_update_hq = mysqli_query($conn, $sql_update_hq)){
								$sql_update_logo = "INSERT INTO logo (account_id) VALUES('$accountId')";
								if($query_update_logo = mysqli_query($conn, $sql_update_logo)){
									$sql_update_profile = "INSERT INTO profile_image (user_id) VALUES($user_id)";
									$query_update_profile = mysqli_query($conn, $sql_update_profile);
								}
							}
						}
					}


								$logo_directory = 'logo_account/'.$accountId;
								if(!is_dir($logo_directory)){
									mkdir($logo_directory, 0777, true);
								}
							//make visitor photo directory per account
							$visitor_directory = 'webcamImage/'.$accountId;
							if(!is_dir($visitor_directory)){
								mkdir($visitor_directory, 0777, true);
								//mail function to send registration mail
								$sql_user_mail = "SELECT * FROM user WHERE email=? AND account_id=?";
							  if($stmt_user_mail = mysqli_prepare($conn, $sql_user_mail)){
							    mysqli_stmt_bind_param($stmt_user_mail, "ss", $param_email, $param_account_id);
							    $param_email = $email;
							    $param_account_id = $accountId;
							    if(mysqli_stmt_execute($stmt_user_mail)){
							      $result_user_mail = mysqli_stmt_get_result($stmt_user_mail);
							      $row_user_mail = mysqli_fetch_array($result_user_mail, MYSQLI_ASSOC);
										$to_email = $row_user_mail['email'];
										$to = "$to_email";
										$subject = 'VisiMonk Registration!';
										$message = 'Dear '.$row_user_mail['user_name'].",". "\r\n"."\r\n".
						        'Thank you for registering with VisiMonk'. "\r\n".
						        'Please click on the below link to activate your account!'. "\r\n".
						        'app.visimonk.com/register_activate.php?e='.$row_user_mail['email'].'&tc='.$row_user_mail['token_code']. "\r\n"."\r\n".
						        'Regards,'. "\r\n".
										'Team VisiMonk'. "\r\n";
										$headers = 'From: registration@visimonk.com' . "\r\n" .
				             'Reply-To: support@visimonk.com' . "\r\n" .
				             'X-Mailer: PHP/' . phpversion();
										 mail($to, $subject, $message, $headers);
										 header('Location: login_view.php?message=register');
							    }
							  }
							}
					}
				} else{
					$errors[] .= 'Something went wrong. Please try again';
				}
				}
			}//insert data
	 // }//main post if
?>
<body class="login">
  <div>
    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <form action="register_view.php" method="post">
            <h1>Create Account</h1>
						<div>
							<?php
								if(!empty($errors)){
									echo display_errors($errors);
								}
							?>
						</div>
            <div>
              <input type="text" class="form-control" name="fullName" placeholder="Full Name" required="" value="<?=(isset($_POST['register'])?$_POST['fullName']:'')?>"/>
            </div>
            <div>
              <input type="text" class="form-control" name="companyName" placeholder="Company Name" required="" value="<?=(isset($_POST['register'])?$_POST['companyName']:'')?>"/>
            </div>
            <div>
              <input type="number" class="form-control" name="phoneNumber" placeholder="Phone Number" required="" value="<?=(isset($_POST['register'])?$_POST['phoneNumber']:'')?>"/>
            </div>
            <br>
            <div>
              <input type="email" class="form-control" name="email" placeholder="Email" required="" value="<?=(isset($_POST['register'])?$_POST['email']:'')?>"/>
            </div>
            <div>
              <input type="password" class="form-control" name="password" placeholder="Password" required="" />
            </div>
            <div>
              <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm Password" required="" />
            </div>
            <div>
              <input type="submit" class="btn btn-default submit" name="register" value="Register" />
            </div>

            <div class="clearfix"></div>

            <div class="separator">
              <p class="change_link">Already Registered?
                <a href="login_view.php" class="to_register"> Login </a>
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

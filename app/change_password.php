<?php
	include 'include/head.php';
	require_once 'include/dbConfig.php';
	checkLogin();
  $errors = array();

  if(isset($_POST) && !empty($_POST)){
    $old_password = clean($_POST['old_password']);
    $password = clean($_POST['password']);
    $confirm_password = clean($_POST['confirm_password']);
    if(empty($old_password && $password && $confirm_password)){
      $errors[] .= 'All fields are mandatory';
    }

    if($password != $confirm_password){
      $errors[] .= 'Passwords do not match!';
    }

    if(empty($errors)){
			//prepare a select statement
			$sql = "SELECT email, password FROM user WHERE email = ?";
			if($stmt = mysqli_prepare($conn, $sql)){
				//bind variable to prepared statement as parameter
				mysqli_stmt_bind_param($stmt, "s", $userEmail);
				//attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){
					/*store results*/
					mysqli_stmt_store_result($stmt);
					if(mysqli_stmt_num_rows($stmt) == 1){
						//validate password
						//bind results variable
						mysqli_stmt_bind_result($stmt, $email, $hashed_password);
						if(mysqli_stmt_fetch($stmt)){
							if(password_verify($old_password, $hashed_password)){
								/*password is correct */
                $sqlUser = "UPDATE user SET password = ? WHERE email=? AND account_id=?";
                if($stmtUser = mysqli_prepare($conn, $sqlUser)){
                  $password = password_hash($password, PASSWORD_DEFAULT);
                  mysqli_stmt_bind_param($stmtUser, "sss", $password, $userEmail, $accountId );
                  if(mysqli_stmt_execute($stmtUser)){
                    header('location: login_view.php?message=change_password');
                  }
                }
							}else{
                /*Password is incorrect*/
                $errors[] .= 'Old Password is incorrect';
							}
						}//fetch statement
					}
				}
			}
			//close statement
			mysqli_stmt_close($stmt);
		}//email validation
  }
?>
  <body class="nav-md footer_fixed">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <?php include 'include/brand.php'; ?>
            <div class="clearfix"></div>
            <br />
            <?php
				include 'include/sidebarMenu.php';
			?>
          </div>
        </div>
        <?php
			include 'include/topNav.php';
		?>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Change Password</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
                    <div>
                      <?php
                        if(!empty($errors)){
                          echo display_errors($errors);
                        }
                      ?>
                    </div>
                      <!--form start-->
                      <form data-parsley-validate class="form-horizontal form-label-left" action="change_password.php" method="POST">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="old-password">Old Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" id="old-password" name="old_password" required="required" class="form-control col-md-7 col-xs-12"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="new-password">New Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" id="new-password" name="password" required="required" class="form-control col-md-7 col-xs-12"/>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="confirm-password">Confirm Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" id="confirm-password" name="confirm_password" required="required" class="form-control col-md-7 col-xs-12"/>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <a class="btn btn-warning" type="button" href="profile_view.php">Cancel</a>
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>
                    </form>
                      <!--form end-->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
        <?php
			include 'include/footer.php';
		?>
      </div>
    </div>
<?php
	include 'include/script.php';
?>
